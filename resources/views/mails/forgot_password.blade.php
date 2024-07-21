<x-mail::message>
	# Request New Password

	Hello {{ $username }},

	Reset Your Password with This Button Below!

	<x-mail::button url="{{ route('resetPassword', $token) }}">
		Reset Password
	</x-mail::button>

	Thanks,<br>
	{{ config('app.name') }}
</x-mail::message>
