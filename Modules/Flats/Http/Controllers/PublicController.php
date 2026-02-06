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

            // Set footer for pagination
            $mpdf->SetHTMLFooter('<table width="100%" style="font-size: 9pt;"><tr><td width="33%"></td><td width="33%" align="center">{PAGENO} / {nbpg}</td><td align="right" width="33%">' . ($_SERVER['HTTP_HOST'] ?? '') . '</td></tr></table>');

            // PDF contains only this flat/loft's own floor plan(s): 1 page for flats, 2–3 pages for lofts (by level count)
            $html = view('flats::public.pdf')
                ->with([
                    'model' => $model,
                    'image' => $model->image?->path,
                    'level' => 1,
                    'totalLevels' => $model->getPdfLevelCount(),
                    'lang' => $lang,
                ])
                ->render();
            $mpdf->WriteHTML($html);

            if ($model->has_second_floor && $model->second_image) {
                $mpdf->AddPage();
                $html = view('flats::public.pdf')
                    ->with([
                        'model' => $model,
                        'image' => $model->second_image->path,
                        'level' => 2,
                        'totalLevels' => $model->getPdfLevelCount(),
                        'lang' => $lang,
                    ])
                    ->render();
                $mpdf->WriteHTML($html);
            }

            if ($model->getAttribute('has_third_floor') && $model->getAttribute('third_image_id') && $model->third_image) {
                $mpdf->AddPage();
                $html = view('flats::public.pdf')
                    ->with([
                        'model' => $model,
                        'image' => $model->third_image->path,
                        'level' => 3,
                        'totalLevels' => $model->getPdfLevelCount(),
                        'lang' => $lang,
                    ])
                    ->render();
                $mpdf->WriteHTML($html);
            }

            $filename = str_replace('/', '-', $model->number);
            $filename = str_replace(' ', '-', $filename);
            $filename = preg_replace('/[^A-Za-z0-9\-\_]/', '', $filename);
            $filename = preg_replace('/-+/', '-', $filename);
            $filename = 'JurasSkati_' . $filename . '_' . $lang . '.pdf';
            return response()->streamDownload(function () use ($mpdf, $filename) {
                echo $mpdf->Output($filename, 'D');
            }, $filename);
        } finally {
            ini_set('pcre.backtrack_limit', $originalBacktrackLimit);
        }
    }
}
