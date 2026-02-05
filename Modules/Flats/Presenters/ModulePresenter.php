<?php

namespace TypiCMS\Modules\Flats\Presenters;

use TypiCMS\Modules\Core\Presenters\Presenter;
use Bkwld\Croppa\Facades\Croppa;
use Illuminate\Support\Facades\Storage;

class ModulePresenter extends Presenter
{

    /**
     * Get the path of the first image linked to this model
     * or the path to the default image.
     */
    protected function getSecondImagePathOrDefault(): string
    {
        $path = $this->entity->second_image->path ?? '';

        if (!Storage::exists($path)) {
            $path = $this->imgNotFound();
        }

        

        return $path;
    }

    /**
     * Return src string of a resized or cropped image.
     */
    public function second_image(int $width = null, int $height = null, array $options = []): string
    {
        $path = $this->getSecondImagePathOrDefault();

        if (in_array(pathinfo($path, PATHINFO_EXTENSION), ['svg', 'gif'])) {
            return Storage::url($path);
        }

        return url(Croppa::url('storage/'.$path, $width, $height, $options));
    }
}
