<div>
    <h1>Здравствуйте, {{ $user->firstName }} {{ $user->lastName }} Вы прошли регистрацию.</h1>
    <h3>Для потверждения адреса электронной почты пройдите по ссылке {{ route('activation', $user->activationLink) }}.</h3>
</div>