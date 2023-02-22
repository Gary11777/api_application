<x-mail::message>
# Reset Password

Please copy the token and paste it in a respective row in Postman:
<br><br>
    The token is: <b>{{ $token }}</b>

{{--<x-mail::button :url="''">
Button Text
</x-mail::button>--}}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
