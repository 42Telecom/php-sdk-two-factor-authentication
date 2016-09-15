TWO FACTOR AUTHENTICATION FOR FORTYTWO
=======================================

This SDK help you to use the Two Factor Authentication service from [FortyTwo Telecom](http://www.fortytwo.com)

## How to use it:

### With composer:
Using [composer](https://getcomposer.org/):
```
    composer require fortytwo/php-sdk-two-factor-authentication
```

### directly:

You can download the library from the [Fortytwo Telecom website](https://www.fortytwo.com/developers/) or on our [official Github repository](https://github.com/42Telecom/php-sdk-two-factor-authentication).

## Testing:

Execute the following command on the project directory:
```
vendor/bin/phpunit -c tests/Phpunit.xml
```

Currently the  code coverage is 100%.

## API:

The SDK expose 2 main functions:

### TwoFactorAuthentication::requestCode()

Parameters:

| Name         | Type   | Required | Description                 |
|--------------|--------|----------|-----------------------------|
| clientRef    | String | Yes      | Client reference.           |
| phoneNumber  | String | Yes      | Destination Phone number.   |
| optionalArgs | Array  | No       | List of optionals arguments |

List of optionals arguments:

| Name            | Type    | Default  | Constraints                        | Description             |
|-----------------|---------|----------|------------------------------------|-------------------------|
| codeLength      | Integer | 6        | Maximum value 20                   | 2FA Code                |
| codeType        | String  | Numeric  | alpha, numeric or alphanumeric     | 2FA Code type.          |
| caseSensitive   | Boolean | null     | True or False                      | 2FA Code case sensitive |
| callbackUrl     | String  | null     | URL format withscheme (http/https) | 2FA Callback URL.       |
| senderId        | String  | null     | -                                  | Custom sender ID.       |
| messageTemplate | String  | null     | {#TFA_CODE} Required               | Custom message template |

You can found a more detailled description of each parameter in the [API documentation](https://www.fortytwo.com/apis/two-factor-authentication/request-code/)

### TwoFactorAuthentication::validateCode()

Parameters:

| Name         | Type   | Required | Description                 |
|--------------|--------|----------|-----------------------------|
| clientRef    | String | Yes      | Client reference.           |
| code         | String | Yes      | 2FA Code.                   |

You can found a more detailled description of each parameter in the [API documentation](https://www.fortytwo.com/apis/two-factor-authentication/validate-code/)
