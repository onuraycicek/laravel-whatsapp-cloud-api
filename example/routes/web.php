<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use WCA\WCA\Package\Message\Media\MediaObjectID;

Route::get('/', function () {

    return view('welcome');
});

Route::get('/business-profile', function (Request $request) {
    try {
        $wca = new WCA\WCA\WCA([
            'from_phone_number_id' => $request->from_phone_number_id ?? env('WCA_FROM_PHONE_NUMBER_ID'),
            'business_id' => env('WCA_BUSINESS_ID'),
        ]);

        $response = $wca->businessProfile('about,address,description,email,profile_picture_url,websites,vertical');
        $data = $response->decodedBody()['data'][0];
    } catch (\Throwable $th) {
        if (json_decode($th->getMessage())) {
            return json_decode($th->getMessage())->error->message;
        }

        return $th->getMessage();
    }

    return view('sections.business_profile', [
        'fromPhoneNumberId' => $request->from_phone_number_id ?? env('WCA_FROM_PHONE_NUMBER_ID'),
        'businessProfile' => $data,
    ]);
})->name('business-profile');

Route::post('/send-message', function (Request $request) {
    try {
        $wca = new WCA\WCA\WCA([
            'from_phone_number_id' => $request->from_phone_number_id ?? env('WCA_FROM_PHONE_NUMBER_ID'),
            'business_id' => env('WCA_BUSINESS_ID'),
        ]);

        if ($request->has('file')) {
            $uploadedFiles = [];
            //upload
            foreach ($request->file as $file) {
                // save file temporarily random name
                $randomName = Str::random(10);
                $tempName = $randomName.'.'.$file->getClientOriginalExtension();
                $file->storeAs('temp', $tempName);
                $response = $wca->uploadMedia(
                    storage_path('app/temp/'.$tempName)
                );
                $id = $response->decodedBody()['id'];
                $uploadedFiles[] = [
                    'id' => new MediaObjectID($id),
                    'name' => $file->getClientOriginalName(),
                    'temp_name' => $tempName,
                ];
            }

            // send
            foreach ($uploadedFiles as $key => $file) {
                $caption = $key == 0 ? $request->message : null; // send caption only first file
                $response = $wca->sendDocument(
                    to: $request->to_phone_number ?? env('WCA_TARGET_PHONE_NUMBER'),
                    document_id: $file['id'],
                    name: $file['name'],
                    caption: $caption
                );
            }

            // remove temporary files
            foreach ($uploadedFiles as $file) {
                unlink(storage_path('app/temp/'.$file['temp_name']));
            }

            return $response->body();
        } else {
            $response = $wca->sendTextMessage(
                to: $request->to_phone_number ?? env('WCA_TARGET_PHONE_NUMBER'),
                text: $request->message
            );
        }

        return $response->body();
    } catch (\Throwable $th) {
        if (method_exists($th, 'getMessage') && json_decode($th->getMessage())) {
            return json_decode($th->getMessage())->error->message;
        }

        return $th;
    }
})->name('send-message');

Route::get('/phone-numbers', function () {

    try {
        $wca = new WCA\WCA\WCA([
            'from_phone_number_id' => env('WCA_FROM_PHONE_NUMBER_ID'),
            'business_id' => env('WCA_BUSINESS_ID'),
        ]);

        $response = $wca->getBusinessPhoneNumbers();
        $data = $response->decodedBody()['data'];
    } catch (\Throwable $th) {
        if (json_decode($th->getMessage())) {
            return json_decode($th->getMessage())->error->message;
        }

        return $th->getMessage();
    }

    return view('sections.phone_numbers', [
        'phoneNumbers' => $data,
    ]);
})->name('phone-numbers');

Route::get('/template-messages', function () {

    try {
        $wca = new WCA\WCA\WCA([
            'from_phone_number_id' => env('WCA_FROM_PHONE_NUMBER_ID'),
            'business_id' => env('WCA_BUSINESS_ID'),
        ]);

        $allTemplates = [];
        $after = null;
        do {
            $response = $wca->getBusinessTemplateMessages($after);
            $data = $response->decodedBody();
            if (! isset($data['data']) || empty($data['data'])) {
                break;
            }
            $allTemplates = array_merge($allTemplates, $data['data']);
            $after = $data['paging']['cursors']['after'] ?? null;
        } while ($after !== null);
        $data = $response->decodedBody();
    } catch (\Throwable $th) {
        if (json_decode($th->getMessage())) {
            return json_decode($th->getMessage())->error->message;
        }

        return $th->getMessage();
    }

    return view('sections.template_messages', [
        'templateMessages' => $allTemplates,
    ]);
})->name('template-messages');

Route::post('/send-template-message', function (Request $request) {
    try {
        $wca = new WCA\WCA\WCA([
            'from_phone_number_id' => $request->from_phone_number_id ?? env('WCA_FROM_PHONE_NUMBER_ID'),
            'business_id' => env('WCA_BUSINESS_ID'),
        ]);

        $response = $wca->sendTemplate(
            to: $request->to_phone_number ?? env('WCA_TARGET_PHONE_NUMBER'),
            template_name: $request->template_name
        );

        return $response->body();
    } catch (\Throwable $th) {
        if (json_decode($th->getMessage())) {
            return json_decode($th->getMessage())->error->message;
        }

        return $th->getMessage();
    }
})->name('send-template-message');

Route::post('/download-media', function (Request $request) {
    try {
        $wca = new WCA\WCA\WCA([
            'from_phone_number_id' => $request->from_phone_number_id ?? env('WCA_FROM_PHONE_NUMBER_ID'),
            'business_id' => env('WCA_BUSINESS_ID'),
        ]);

        $response = $wca->downloadMedia(
            media_id: $request->media_id
        );
        $file = $response->body();
        
        $fileName = 'media_'.$request->media_id.'.jpg'; // whatsapp webhook returns media type
        $filePath = storage_path('app/public/'.$fileName);
        file_put_contents($filePath, $file);
        return asset('storage/'.$fileName);

    } catch (\Throwable $th) {
        if (json_decode($th->getMessage())) {
            return json_decode($th->getMessage())->error->message;
        }

        return $th->getMessage();
    }
})->name('download-media');
