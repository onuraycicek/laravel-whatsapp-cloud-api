<?php

namespace WCA\WCA\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class WebhookController extends BaseController
{
	public function webhook_register(Request $request){
		Log::info('GET /webhook', $request->all());
		if($request->has('hub_verify_token') && $request->hub_verify_token === config('whatsapp-cloud-api.verify_token')){
			return $request->hub_challenge;
		}
	}

	// https://developers.facebook.com/docs/whatsapp/on-premises/webhooks/inbound/#received-messages-examples
	public function webhook(Request $request){
		Log::info('POST /webhook', $request->all());
	}
}
