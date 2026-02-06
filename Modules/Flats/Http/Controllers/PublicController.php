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

        // Determine total number of floors
        $totalFloors = 1;
        if ($model->has_second_floor && $model->second_image) {
            $totalFloors = 2;
        }

        // Set footer with page numbers if there are multiple pages
        if ($totalFloors > 1) {
            $mpdf->SetHTMLFooter('<table width="100%" style="font-size: 9pt;"><tr><td width="33%"></td><td width="33%" align="center">{PAGENO} / {nbpg}</td><td align="right" width="33%">' . $_SERVER['HTTP_HOST'] . '</td></tr></table>');
        } else {
            $mpdf->SetHTMLFooter('<table width="100%" style="font-size: 9pt;"><tr><td width="33%"></td><td width="33%"></td><td align="right" width="33%">' . $_SERVER['HTTP_HOST'] . '</td></tr></table>');
        }

        // First floor
        $html = view('flats::public.pdf')
            ->with([
                'model' => $model,
                'image' => $model->image->path,
                'level' => 1,
                'totalFloors' => $totalFloors,
            ])
            ->render();
        $mpdf->WriteHTML($html);

        // Second floor (if exists)
        if ($model->has_second_floor && $model->second_image) {
            $mpdf->AddPage();
            $html = view('flats::public.pdf')
                ->with([
                    'model' => $model,
                    'image' => $model->second_image->path,
                    'level' => 2,
                    'totalFloors' => $totalFloors,
                ])
                ->render();
            $mpdf->WriteHTML($html);
        }

        $filename = str_replace('/', '-', $model->number);
        $filename = str_replace(' ', '-', $filename);
        $filename = preg_replace('/[^A-Za-z0-9\-\_]/', '', $filename);
        $filename = preg_replace('/-+/', '-', $filename);
        $filename = 'JurasSkati_' . $filename . '_' . config('app.locale') . '.pdf';
        return response()->streamDownload(function() use ($mpdf , $filename) {
            echo $mpdf->Output($filename, 'D');
        }, $filename);
    }
}
