<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\APIController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Site\ContactFormRequest;
use App\Http\Requests\Site\RecaptchaRequest;
use App\Http\Resources\Site\ContactResource;
use App\Http\Resources\Site\LayoutResource;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class SiteController extends APIController
{
    public function layout()
    {
     return new LayoutResource(null);
    }

    public function contact()
    {
        return new ContactResource(null);
    }

    public function storeContactMessage(ContactFormRequest $request)
    {
        ContactMessage::create($request->all());
        return $this->JSON('success', 'true', 200);
    }

    public function recaptcha(RecaptchaRequest $request)
    {
        return $this->JSON("success","true",200);
    }


}
