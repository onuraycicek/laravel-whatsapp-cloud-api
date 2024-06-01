# WCA Package ReadMe

## Introduction

This package is designed to facilitate interactions with the WCA API, providing functionality for handling business profiles, uploading and sending media, and managing phone numbers. You can see the demo application by running the laravel project in the **example** folder.

## Installation

To install the WCA package, use the following composer command:

```bash
composer require onuraycicek/laravel-whatsapp-cloud-api
```

## Configuration

Before using the package, ensure that you have the following environment variables set in your .env file:

```bash
WCA_BUSINESS_ID=your_business_id
WCA_ACCESS_TOKEN=your_whatsapp_access_token
//optional
WCA_FROM_PHONE_NUMBER_ID=your_from_phone_number_id
WCA_TARGET_PHONE_NUMBER=your_target_phone_number
DEFAULT_GRAPH_VERSION=v19.0 
```

## Usage

### Business Profile
To retrieve the business profile information:

```php
try {
    $wca = new WCA\WCA\WCA([
        'from_phone_number_id' => $request->from_phone_number_id ?? env('WCA_FROM_PHONE_NUMBER_ID'),
        'business_id' => env('WCA_BUSINESS_ID'),
    ]);

    $response = $wca->businessProfile("about,address,description,email,profile_picture_url,websites,vertical");
    $data = $response->decodedBody()["data"][0];
} catch (\Throwable $th) {
    if (json_decode($th->getMessage())) {
        return json_decode($th->getMessage())->error->message;
    }
    return $th->getMessage();
}
```

### Upload and Send Media
To upload and send media:

```php
    try {
        $wca = new WCA\WCA\WCA([
            'from_phone_number_id' => $request->from_phone_number_id ?? env('WCA_FROM_PHONE_NUMBER_ID'),
            'business_id' => env('WCA_BUSINESS_ID'),
        ]);

        if ($request->has("file")) {
            $uploadedFiles = [];
            //upload
            foreach ($request->file as $file) {
                // save file temporarily random name
                $randomName = Str::random(10);
                $tempName = $randomName . '.' . $file->getClientOriginalExtension();
                $file->storeAs('temp', $tempName);
                $response = $wca->uploadMedia(
                    storage_path('app/temp/' . $tempName)
                );
                $id = $response->decodedBody()["id"];
                $uploadedFiles[] = [
                    "id" => new MediaObjectID($id),
                    "name" => $file->getClientOriginalName(),
                    "temp_name" => $tempName,
                ];
            }

            // send
            foreach ($uploadedFiles as $key => $file) {
                $caption = $key == 0 ? $request->message : null; // send caption only first file
                $response = $wca->sendDocument(
                    to: $request->to_phone_number ?? env("WCA_TARGET_PHONE_NUMBER"),
                    document_id: $file["id"],
                    name: $file["name"],
                    caption: $caption
                );
            }

            // remove temporary files
            foreach ($uploadedFiles as $file) {
                unlink(storage_path('app/temp/' . $file["temp_name"]));
            }


            return $response->body();
        } else {
            $response = $wca->sendTextMessage(
                to: $request->to_phone_number ?? env("WCA_TARGET_PHONE_NUMBER"),
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
```

### Retrieve Business Phone Numbers

To retrieve the business phone numbers:

```php
try {
    $wca = new WCA\WCA\WCA([
        'from_phone_number_id' => env('WCA_FROM_PHONE_NUMBER_ID'),
        'business_id' => env('WCA_BUSINESS_ID'),
    ]);

    $response = $wca->getBusinessPhoneNumbers();
    $data = $response->decodedBody()["data"];
} catch (\Throwable $th) {
    if (json_decode($th->getMessage())) {
        return json_decode($th->getMessage())->error->message;
    }
    return $th->getMessage();
}
```

## Error Handling
The package includes error handling to catch and return meaningful messages when exceptions occur. When an error occurs, the message is decoded and returned if it is a JSON object; otherwise, the raw message is returned.

