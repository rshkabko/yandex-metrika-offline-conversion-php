# Yandex Metrika Offline Conversion Client (PHP | APIv2)
[![Packagist](https://img.shields.io/badge/package-meiji/yandex--metrika--offline--conversion--php-blue.svg?style=flat-square)](https://packagist.org/packages/meiji/yandex-metrika-offline-conversion-php)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/meiji/yandex-metrika-offline-conversion-php.svg?style=flat-square)](https://packagist.org/packages/meiji/yandex-metrika-offline-conversion-php)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![PHP >=5.6](https://img.shields.io/badge/php-%3E%3D_5.6-orange.svg?style=flat-square)](https://git.meiji.media/meiji/yandex-metrika-offline-conversion-php)

### Клиент для управения офлайн-данными Яндекс.Метрики используя API

Документацию по доступным методам вскоре появится по [ссылке](https://meiji.media)

_*Внимание!*_ API находится в стадии разработки.

## Installation
Для того, чтобы подключить библиотеку в свой проект, можно воспользоваться [composer](https://getcomposer.org)

```bash
composer require rshkabko/yandex-metrika-offline-conversion-php
```

## Usage
Пример загрузки офлайн-конверсий

При добавлении конверсии используется метод:
```
\Meiji\YandexMetrikaOffline\Scope\Upload::addConversion(
	$cid, 				// идентификатор посетителя сайта
	$target,  			// идентификатор цели
	$dateTime = null, 	// дата и время конверсии в формате unix timestamp (по умолчанию - текущее)
	$price = null, 		// цена (не обязательно)
	$currency = null 	// валюта (не обязательно)
);
```

```php
use Meiji\YandexMetrikaOffline\Conversion;

$oauthToken = 'dsERGE4564GBFDG34t3GDEREBbrgbdfbg4564DG3'; // OAuth-токен
$counterId = 123456; // идентификатор счетчика
$client_id_type = 'CLIENT_ID'; // или USER_ID / YCLID

$metrikaOffline = new \Meiji\YandexMetrikaOffline\Conversion($oauthToken);
$metrikaConversionUpload = $metrikaOffline->upload($counterId, $client_id_type);
$metrikaConversionUpload->comment('Комментарий к загрузке'); // Опционально

$metrikaConversionUpload->addConversion('133591247640966458', 'GOAL1', '1481718166'); // Добавяем конверсию
$metrikaConversionUpload->addConversion('579124169844706072', 'GOAL3', '1481718116', '678.90', 'RUB'); // Добавяем ещё конверсию
/* ... и далее добавляем необходимое количество конверсий ... */

$uploadResult = $metrikaConversionUpload->send(); // Отправляем данные. $uploadResult содержит информацию о передаче, в соотвествии с объектом "uploading"
```
