<x-mail::message>
# Introduction

Please copy the token and paste it in a respective row into Postman:
<br><br>
    The token is: {{ $token }}

{{--<x-mail::button :url="''">
Button Text
</x-mail::button>--}}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
