<?php

namespace TypiCMS\Modules\Flats\Http\Controllers;

use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Flats\Models\Flat;
use Mpdf\Mpdf;

class PublicController extends BasePublicController
{
    public function index(): View
    {
        $models = Flat::published()->order()->with('image')->get();

        return view('flats::public.index')
            ->with(compact('models'));
    }

    public function show($slug): View
    {
        $model = Flat::published()->whereSlugIs($slug)->firstOrFail();

        return view('flats::public.show')
            ->with(compact('model'));
    }

    public function download($id)
    {
        $model = Flat::findOrFail($id);
        
        // Get locale from request segment (first segment is lang in routes like {lang}/flats/download/{id})
        $lang = request()->segment(1);
        if (!in_array($lang, ['lv', 'en', 'ru'])) {
            $lang = app()->getLocale();
        }

        // Increase backtrack limit to handle large SVG files
        $originalBacktrackLimit = ini_get('pcre.backtrack_limit');
        ini_set('pcre.backtrack_limit', '5000000');
        
        try {
            $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];
            $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];
            $mpdf = new Mpdf([
                'fontDir' => array_merge($fontDirs, [
                    resource_path('fonts'),
                ]),
                'fontdata' => $fontData + [ // lowercase letters only in font key
                    'montserrat' => [
                        'R' => 'montserrat-v25-latin-ext_latin_cyrillic-regular.ttf',
                    ]
                ],
                'default_font' => 'montserrat',
                'mode' => 'utf-8', 
                'format' => 'A4-L',
                'margin_top' => 10,
                'maragin_bottom' => 10,
                'margin_left' => 10,
                'margin_right' => 10,
                'useSubstitutions' => false,
                'simpleTables' => false,
                'use_kwt' => true,
                'autoScriptToLang' => true,
                'autoLangToFont' => true,
            ]);

            // Determine building type and floor plans
            $isApartment = $model->type === 'apartment';
            $floorPlans = [];
            
            if ($isApartment) {
                // Apartments: floors 1-10 (a1.svg through a10.svg)
                for ($i = 1; $i <= 10; $i++) {
                    $floorPlans[] = [
                        'file' => 'a' . $i . '.svg',
                        'floor' => $i,
                        'type' => 'apartment'
                    ];
                }
            } else {
                // Lofts: floors 1-3 (l1.svg through l3.svg)
                for ($i = 1; $i <= 3; $i++) {
                    $floorPlans[] = [
                        'file' => 'l' . $i . '.svg',
                        'floor' => $i,
                        'type' => 'loft'
                    ];
                }
            }

            // Set footer for pagination
            $mpdf->SetHTMLFooter('<table width="100%" style="font-size: 9pt;"><tr><td width="33%"></td><td width="33%" align="center">{PAGENO} / {nbpg}</td><td align="right" width="33%">' . ($_SERVER['HTTP_HOST'] ?? '') . '</td></tr></table>');

            // Add apartment's own floor plan pages FIRST
            $html = view('flats::public.pdf')
                ->with([
                    'model' => $model,
                    'image' => $model->image->path,
                    'level' => 1,
                    'lang' => $lang,
                ])
                ->render();
            $mpdf->WriteHTML($html);

            if ($model->has_second_floor) {
                $mpdf->AddPage();
                $html = view('flats::public.pdf')
                    ->with([
                        'model' => $model,
                        'image' => $model->second_image->path,
                        'level' => 2,
                        'lang' => $lang,
                    ])
                    ->render();
                $mpdf->WriteHTML($html);
            }

            // Add all building floor plans after apartment's own floor plans
            foreach ($floorPlans as $floorPlan) {
                $mpdf->AddPage();
                
                // Read SVG file content to embed it inline for styling
                $svgPath = public_path('images/floorplans/' . $floorPlan['file']);
                $svgContent = '';
                if (file_exists($svgPath)) {
                    $svgContent = file_get_contents($svgPath);
                    $originalSvgContent = $svgContent; // Keep backup of original
                    
                    // Use DOMDocument to process SVG more efficiently
                    // This avoids regex backtrack limit issues
                    try {
                        libxml_use_internal_errors(true);
                        $dom = new \DOMDocument();
                        // Preserve whitespace to maintain formatting
                        $dom->preserveWhiteSpace = true;
                        $dom->formatOutput = false;
                        // Load with options to preserve all attributes and formatting
                        $loaded = @$dom->loadXML($svgContent);
                        
                        if ($loaded && $dom->documentElement) {
                            // Find all elements with class="bg" and add fill attribute ONLY if not already set
                            $xpath = new \DOMXPath($dom);
                            // Register default namespace
                            $xpath->registerNamespace('svg', 'http://www.w3.org/2000/svg');
                            
                            // Query for elements containing "bg" in class attribute
                            $bgElements = $xpath->query('//*[contains(concat(" ", normalize-space(@class), " "), " bg ")]');
                            foreach ($bgElements as $element) {
                                // Only modify if fill attribute is not already set
                                if (!$element->hasAttribute('fill')) {
                                    // Check if parent has unavailable or sold class
                                    $parent = $element->parentNode;
                                    $hasUnavailable = false;
                                    $hasSold = false;
                                    
                                    while ($parent && $parent->nodeType === XML_ELEMENT_NODE) {
                                        $class = $parent->getAttribute('class');
                                        if (strpos($class, 'unavailable') !== false) {
                                            $hasUnavailable = true;
                                            break;
                                        }
                                        if (strpos($class, 'sold') !== false) {
                                            $hasSold = true;
                                            break;
                                        }
                                        $parent = $parent->parentNode;
                                    }
                                    
                                    // Set fill color based on availability
                                    if ($hasUnavailable || $hasSold) {
                                        $element->setAttribute('fill', '#979797');
                                    } else {
                                        $element->setAttribute('fill', '#E8E8E8');
                                    }
                                }
                            }
                            
                            // Save only the SVG element (no XML declaration - mPDF would render it as visible text)
                            $processedSvgContent = $dom->saveXML($dom->documentElement);
                            
                            // Ensure we have valid SVG content
                            if (!empty($processedSvgContent) && strlen($processedSvgContent) > 100 && strpos($processedSvgContent, '<svg') !== false) {
                                $svgContent = $processedSvgContent;
                            } else {
                                $svgContent = self::stripXmlDeclaration($originalSvgContent);
                            }
                        } else {
                            // If loading failed, use original content
                            $svgContent = $originalSvgContent;
                        }
                        
                        libxml_clear_errors();
                    } catch (\Exception $e) {
                        $svgContent = self::stripXmlDeclaration($originalSvgContent);
                        libxml_clear_errors();
                    }
                    
                    // Final check: if SVG content is empty, use original (without declaration)
                    if (empty($svgContent) || strlen(trim($svgContent)) < 100) {
                        $svgContent = self::stripXmlDeclaration($originalSvgContent);
                    }
                } else {
                    $svgContent = '';
                }
                
                // Ensure we have valid SVG content before rendering
                if (empty($svgContent) || strlen(trim($svgContent)) < 100) {
                    $fallbackPath = public_path('images/floorplans/' . $floorPlan['file']);
                    if (file_exists($fallbackPath)) {
                        $svgContent = self::stripXmlDeclaration(file_get_contents($fallbackPath));
                    }
                }
                
                // Always strip XML declaration so it never appears as text in the PDF
                $svgContent = self::stripXmlDeclaration($svgContent);
                
                $html = view('flats::public.pdf-floorplan')
                    ->with([
                        'floorplan' => $floorPlan['file'],
                        'floorNumber' => $floorPlan['floor'],
                        'type' => $floorPlan['type'],
                        'lang' => $lang,
                        'svgContent' => $svgContent,
                    ])
                    ->render();
                $mpdf->WriteHTML($html);
            }

            $filename = str_replace('/', '-', $model->number);
            $filename = str_replace(' ', '-', $filename);
            $filename = preg_replace('/[^A-Za-z0-9\-\_]/', '', $filename);
            $filename = preg_replace('/-+/', '-', $filename);
            $filename = 'JurasSkati_' . $filename . '_' . $lang . '.pdf';
            return response()->streamDownload(function() use ($mpdf , $filename) {
                echo $mpdf->Output($filename, 'D');
            }, $filename);
        } finally {
            // Always restore original backtrack limit
            ini_set('pcre.backtrack_limit', $originalBacktrackLimit);
        }
    }

    /**
     * Remove XML declaration from SVG content so it is not rendered as visible text in PDF.
     */
    private static function stripXmlDeclaration(string $svgContent): string
    {
        if (empty($svgContent)) {
            return $svgContent;
        }
        // Remove <?xml ... ?> declaration (any encoding variant)
        return preg_replace('/<\?xml[^?]*\?>\s*/i', '', $svgContent);
    }
}
