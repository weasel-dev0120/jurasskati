<?php

namespace TypiCMS\Modules\Flats\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laracasts\Presenter\PresentableTrait;
use Spatie\Translatable\HasTranslations;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\Core\Models\File;
use TypiCMS\Modules\Core\Traits\HasFiles;
use TypiCMS\Modules\Core\Traits\Historable;
use TypiCMS\Modules\Flats\Presenters\ModulePresenter;

class Flat extends Base
{
    use HasFiles;
    use HasTranslations;
    use Historable;
    use PresentableTrait;

    public const
        STATUS_AVAILABLE = 0,
        STATUS_ON_REQUEST = 3,
        STATUS_RESERVED = 1,
        STATUS_SOLD = 2;

    public const STATUS_OPTIONS = [
        self::STATUS_AVAILABLE => 'Available',
        self::STATUS_ON_REQUEST => 'On Request',
        self::STATUS_RESERVED => 'Reserved',
        self::STATUS_SOLD => 'Sold',
    ];

    protected $presenter = ModulePresenter::class;

    protected $guarded = [];

    // Cast the availability to int so comparisons are reliable
    protected $casts = [
        'availability' => 'int',
    ];

    // Append both thumb and the computed availability_label to JSON
    protected $appends = ['thumb', 'availability_label'];

    public $translatable = [
        'title',
        'slug',
        'status',
        'summary',
        'body',
    ];

    protected function thumb(): Attribute
    {
        return new Attribute(
            get: fn () => $this->present()->image(null, 54),
        );
    }

    // Relationship to primary image
    public function image(): BelongsTo
    {
        return $this->belongsTo(File::class, 'image_id');
    }

    // Relationship to second image
    public function second_image(): BelongsTo
    {
        return $this->belongsTo(File::class, 'second_image_id');
    }

    public function getFloorplanId(): string
    {
        return
            mb_strtolower(mb_substr($this->type, 0, 1))
            . $this->floor . '_' . $this->floor_location;
    }

    public function getSecondFloorplanId(): string
    {
        if ($this->has_second_floor) {
            return
                mb_strtolower(mb_substr($this->type, 0, 1))
                . ($this->floor + 1)
                . '_' . $this->second_floor_location;
        } else {
            return '';
        }
    }

    public function getLocationClasses(): string
    {
        $value =
            mb_strtolower(mb_substr($this->type, 0, 1))
            . $this->floor . '_' . $this->floor_location;
        if ($this->has_second_floor) {
            $value .=
                ' ' . mb_strtolower(mb_substr($this->type, 0, 1))
                . ($this->floor + 1)
                . '_' . $this->second_floor_location;
        }
        return $value;
    }

    public function isAvailable(): bool
    {
        return $this->availability === self::STATUS_AVAILABLE;
    }

    public function isReserved(): bool
    {
        return $this->availability === self::STATUS_RESERVED;
    }

    public function isOnRequest(): bool
    {
        return $this->availability === self::STATUS_ON_REQUEST;
    }

    public function isSold(): bool
    {
        return $this->availability === self::STATUS_SOLD;
    }

    public function getFormattedPrice(): string
    {
        return $this->isAvailable() ? number_format($this->price, 0, '.', ' ') : '–';
    }

    public function getLivingArea()
    {
        return $this->total_area - $this->outdoor_area;
    }

    /**
     * Get all floor images for this apartment.
     * Returns an array of floor image paths, ordered from first floor to last.
     * 
     * @return array Array of image paths, e.g., ['path/to/image1.jpg', 'path/to/image2.jpg']
     */
    public function getFloorImages(): array
    {
        $floorImages = [];
        
        // Always include the first floor image if it exists
        if ($this->image && $this->image->path) {
            $floorImages[] = $this->image->path;
        }
        
        // Include second floor image if it exists
        if ($this->has_second_floor && $this->second_image && $this->second_image->path) {
            $floorImages[] = $this->second_image->path;
        }
        
        // Future: Add support for third_image, fourth_image, etc. here
        // Example:
        // if ($this->has_third_floor && $this->third_image && $this->third_image->path) {
        //     $floorImages[] = $this->third_image->path;
        // }
        
        return $floorImages;
    }

    /**
     * Get the total number of floors for this apartment.
     * 
     * @return int Number of floors (minimum 1)
     */
    public function getTotalFloors(): int
    {
        return count($this->getFloorImages());
    }

    /**
     * Computed label for availability – used by admin list.
     * Returns: available | on request | reserved | sold
     */
    public function getAvailabilityLabelAttribute(): string
    {
        $map = [
            self::STATUS_AVAILABLE  => 'available',
            self::STATUS_ON_REQUEST => 'on request',
            self::STATUS_RESERVED   => 'reserved',
            self::STATUS_SOLD       => 'sold',
        ];

        return $map[$this->availability] ?? '';
    }
}