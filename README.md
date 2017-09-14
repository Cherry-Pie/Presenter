# Presenter for Eloquent models or arrays

## Install

```bash
composer require yaro/presenter
```

## Usage

Create presenter class and extend it from ```Yaro\Presenter\AbstractPresenter```. And specify ```$arrayable``` keys, which presenter should use from model:
```php
namespace App\Presenters;

use Yaro\Presenter\AbstractPresenter;

class UserPresenter extends AbstractPresenter
{
	protected $arrayable = [
		'name',
		'profession'
	];
}
```

Additionally you can add method for getting specific values:
```php
protected $arrayable = [
	'name',
	'profession',
	'random_number', // <- a virtual key, that model doesnt contain
];

// just studly case your key and surround it with 'get' and 'Present'.
public function getRandomNumberPresent()
{
	return rand(11,22);
}
```


Include trait ```Yaro\Presenter\PresenterTrait``` in your model. And specify presenter class.
```php
use Yaro\Presenter\PresenterTrait;

class User
{
	use PresenterTrait;
	// ...

	protected $presenter = \App\Presenters\UserPresenter::class;

}
```

Or override ```getPresenterClass``` method, if you dont like protected attribute, or just need some extra logic:
```php
class User
{
	use PresenterTrait;
	// ...

	public function getPresenterClass()
    {
    	if ($this->isBlocked()) {
			return \App\Presenters\BlockedUserPresenter::class;
    	}

        return \App\Presenters\UserPresenter::class;
    }

}
```

And just send it to output:
```php
$user = User::first();

return response()->json(compact('user'));
```
```json
{
	"name": "Davy Jones",
	"profession": "pirate",
	"random_number": 13
}
```


## License
The MIT License (MIT). Please see [LICENSE](https://github.com/Cherry-Pie/Presenter/blob/master/LICENSE) for more information.