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

        // Add all building floor plans first
        $firstPage = true;
        foreach ($floorPlans as $floorPlan) {
            if (!$firstPage) {
                $mpdf->AddPage();
            }
            $firstPage = false;
            
            $html = view('flats::public.pdf-floorplan')
                ->with([
                    'floorplan' => $floorPlan['file'],
                    'floorNumber' => $floorPlan['floor'],
                    'type' => $floorPlan['type'],
                    'lang' => $lang,
                ])
                ->render();
            $mpdf->WriteHTML($html);
        }

        // Add apartment's own floor plan pages
        $mpdf->AddPage();
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

        $filename = str_replace('/', '-', $model->number);
        $filename = str_replace(' ', '-', $filename);
        $filename = preg_replace('/[^A-Za-z0-9\-\_]/', '', $filename);
        $filename = preg_replace('/-+/', '-', $filename);
        $filename = 'JurasSkati_' . $filename . '_' . $lang . '.pdf';
        return response()->streamDownload(function() use ($mpdf , $filename) {
            echo $mpdf->Output($filename, 'D');
        }, $filename);
    }
}
