<x-mail::message>
    # Request New Password

    Hello {{ $user->name }},

    Reset Your Password with This Button Below!

    <x-mail::button url="{{ route('resetPassword', $user->remember_token) }}">
        Reset Password
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
