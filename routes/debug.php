<?php

use Illuminate\Support\Facades\Route;

Route::get('debug-playground', function(){
    $idToken = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjA3YjgwYTM2NTQyODUyNWY4YmY3Y2QwODQ2ZDc0YThlZTRlZjM2MjUiLCJ0eXAiOiJKV1QifQ.eyJpc3MiOiJodHRwczovL2FjY291bnRzLmdvb2dsZS5jb20iLCJhenAiOiI4MjY0NjE5Mzk1MS02NjZnY3Rtc3Y1ZnBhZ2tnbmZrZGRoY2FnNWtvb3AzYS5hcHBzLmdvb2dsZXVzZXJjb250ZW50LmNvbSIsImF1ZCI6IjgyNjQ2MTkzOTUxLXV1bWpsdGlhYm5kcTVodThyYzlyOXRxMWF1bzZmZGt0LmFwcHMuZ29vZ2xldXNlcmNvbnRlbnQuY29tIiwic3ViIjoiMTE1MTc3Nzg3MzUyODA1ODE1MzAwIiwiZW1haWwiOiJyaWNreXByaW1hMzBAZ21haWwuY29tIiwiZW1haWxfdmVyaWZpZWQiOnRydWUsIm5hbWUiOiJSaWNreSBQcmltYSIsInBpY3R1cmUiOiJodHRwczovL2xoMy5nb29nbGV1c2VyY29udGVudC5jb20vYS9BQ2c4b2NKaGw1RHAzTklObXcyS21CcktyUFZQR2hnRVZZVi1NVzJpNWV1aFdnanQyS0hIMHRWVz1zOTYtYyIsImdpdmVuX25hbWUiOiJSaWNreSIsImZhbWlseV9uYW1lIjoiUHJpbWEiLCJpYXQiOjE3NDYzNzE1OTYsImV4cCI6MTc0NjM3NTE5Nn0.azJY0gBeETyv0kWMTDy_BMIVQ8rW4c4zzynW-J8A9_JAgFS7j9Q7_f8LH1MPvyB2Nlu0iwi94a3MeFqtGf7GrrlROkQcUIGYDqorMQOdqSL7_qUs84z3pSc1Oa1YQgFaKXB1gYzs0ZvhHj9k-qPTFxUx8mMVcaQlKzsWMlX_Vm5CEHE-RPbuNPP8Jw6IZFdqnLpqJPxBgTdrbEFBfqIc7J9Z80NhdhAtCcfvs_eJt-A";

    // Split the token into parts
    $tokenParts = explode('.', $idToken);
    $header = json_decode(base64_decode($tokenParts[0]), true);
    $payload = json_decode(base64_decode($tokenParts[1]), true);
    $signature = base64_decode(strtr($tokenParts[2], '-_', '+/'));

    // Check the payload
    dd($header, $payload);
});
