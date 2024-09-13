<?php

namespace App\Nova;

use App\Models\LegalDocument as LegalDocumentModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class LegalDocument extends Resource
{
    public static $model = 'App\Models\LegalDocument';

    public function fields(NovaRequest $request)
    {
        $isCreating = $request->isMethod('post');
        $id = $request->route('resourceId');

        return [
            Text::make('Title', 'title')
                ->rules('required'),

            Select::make('Language')
                ->options([
                    'en' => 'English',
                    'de' => 'German',
                ])
                ->displayUsingLabels()
                ->rules('required'),

            File::make('Upload File', 'file')
                ->disk('public')
                ->path('legal_documents')
                ->rules($isCreating ? 'required' : ''),

            Select::make('Type')
                ->options([
                    'privacy' => 'Privacy Policy',
                    'imprint' => 'Imprint',
                    'transparency_document' => 'Transparency Document',
                    'whistleblower_protection' => 'Whistleblower protection',
                    'code_of_conduct' => 'Code of Conduct',
                    'policy_terms_conditions' => 'Privacy policy-terms and conditions',
                    'list_of_processors' => 'List of processors',
//                   'technical_measures' => 'Technical and Organizational Measures',
//                   'certification_mark' => 'Certification Mark Policy',
                ])
                ->displayUsingLabels()
                ->rules('required', function ($attribute, $value, $fail) use ($request, $id) {
                    $language = $request->get('language');
                    $exists = LegalDocumentModel::where('type', $value)
                        ->where('language', $language)
                        ->when($id, function ($query) use ($id) {
                            $query->where('id', '!=', $id);
                        })
                        ->exists();

                    if ($exists) {
                        $fail('The combination of Type and Language has already been taken.');
                    }
                }),
        ];
    }
}
