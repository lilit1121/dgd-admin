<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Resource as NovaResource;
use Illuminate\Http\Request;

class Post extends NovaResource
{
    public static $model = 'App\Models\Post';

    public function fields(Request $request)
    {
        return [

            Text::make('Title', 'post_title')
                ->rules('required'),
            Textarea::make('Content', 'post_content'),
            Select::make('Status', 'post_status')
                ->options(['publish' => 'Publish', 'draft' => 'Draft'])
                ->rules('required'),
            Text::make('Post type', 'post_type')
                ->rules('required'),
        ];
    }

    public static $search = [
        'id', 'post_title', 'post_content', 'post_status', 'post_type',
    ];
}
