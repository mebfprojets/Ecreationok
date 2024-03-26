<?php

namespace Laravel\Fortify\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
<<<<<<< HEAD
=======
use Laravel\Fortify\Contracts\EmailVerificationNotificationSentResponse;
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
use Laravel\Fortify\Fortify;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $request->wantsJson()
                        ? new JsonResponse('', 204)
                        : redirect()->intended(Fortify::redirects('email-verification'));
        }

        $request->user()->sendEmailVerificationNotification();

<<<<<<< HEAD
        return $request->wantsJson()
                    ? new JsonResponse('', 202)
                    : back()->with('status', Fortify::VERIFICATION_LINK_SENT);
=======
        return app(EmailVerificationNotificationSentResponse::class);
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    }
}
