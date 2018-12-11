<?php

namespace App\Images;


/**
 * App\Images\Image
 *
 * @property int $id
 * @property string $source
 * @property string|null $tag
 * @property int $owner_id
 * @property string $owner_class
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Images\Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Images\Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Images\Image whereOwnerClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Images\Image whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Images\Image whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Images\Image whereTag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Images\Image whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Image extends \Eloquent
{

    protected $table = 'images';

    public $timestamps = false;

    protected $owner;

    protected $fillable = [
	'source',
	'owner_id',
	'owner_class',
    ];

    public function setSourceAttribute($value)
    {
        $value = str_replace([ 'jpeg' ], [ 'jpg' ], $value);
        $this->attributes['source'] = $value;
    }

    public function url($size = false, $dummy = null)
    {

        if (!$size) {
            $webPath = sprintf(config()->get('images.web_path') . "/%s.%s", $this->id, $this->source);

            return \URL::to($webPath);
        }

        list($w, $h) = explode("x", $size, 2);

        $imagePath = sprintf(config()->get('images.path') . "/%s.%s", $this->id, $this->source);

        $thumbPath = sprintf(config()->get('images.path') . "/%s_%sx%s.%s", $this->id, $w, $h, $this->source);

        $webPath = sprintf(config()->get('images.web_path') . "/%s_%sx%s.%s", $this->id, $w, $h, $this->source);

        if (!$this->id || !file_exists($imagePath)) {
            return $dummy;
        }

        if (!file_exists($thumbPath)) {

            $resizeShellCommand = sprintf('convert -quality 80 -gravity North -resize %s^ -extent %s %s %s', $size,
                $size, $imagePath, $thumbPath);

            shell_exec($resizeShellCommand);

        }

        return \URL::to($webPath);

    }

    public function md5()
    {

        $key = 'img_md5_' . $this->id;

        $imagePath = sprintf(\Config::get('images.path') . "/%s.%s", $this->id, $this->source);

        if ($this->id && file_exists($imagePath)) {

            if (\Cache::has($key)) {
                return \Cache::get($key);
            } else {
                \Cache::put($key, md5_file($imagePath), 10080);
            }

            return \Cache::get($key);

        } else {
            return null;
        }

    }

}
