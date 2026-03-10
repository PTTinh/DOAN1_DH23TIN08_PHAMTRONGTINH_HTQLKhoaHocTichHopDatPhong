<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class News
 * 
 * @property int $id
 * @property string|null $title
 * @property string|null $slug
 * @property string|null $summary
 * @property string $content
 * @property string|null $featured_image
 * @property int|null $author_id
 * @property bool $is_featured
 * @property bool $is_published
 * @property Carbon|null $published_at
 * @property int $view_count
 * @property int|null $category_id
 * @property string|null $seo_title
 * @property string|null $seo_image
 * @property string|null $seo_description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User|null $user
 * @property NewsCategory|null $news_category
 *
 * @package App\Models
 */
class News extends Model
{
	protected $table = 'news';
	protected $primaryKey = 'news_id';

	protected $casts = [
		'author_id' => 'int',
		'is_featured' => 'bool',
		'is_published' => 'bool',
		'published_at' => 'datetime',
		'category_id' => 'int'
	];

	protected $fillable = [
		'title',
		'slug',
		'summary',
		'content',
		'featured_image',
		'author_id',
		'is_featured',
		'is_published',
		'published_at',
		'category_id',
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'author_id');
	}

	public function news_category()
	{
		return $this->belongsTo(NewsCategory::class, 'category_id');
	}
}
