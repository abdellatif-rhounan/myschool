<x-mail::message>
	# Request New Password

	Hello {{ $name }},

	Reset Your Password with This Button Below!

	<x-mail::button url="{{ route('reset-password', [$user_type, $remember_token]) }}">
		Reset Password
	</x-mail::button>

	Thanks,<br>
	{{ config('app.name') }}
</x-mail::message>
