# Roman

Convert integers to roman numerals and back again.

## To roman

```php
echo Roman::toRoman(1997);
//'MCMXCVII'

echo Roman::toRoman(148);
//'CXLVIII'
```

Only numbers between 1 and 3999 are allowed. Any others will throw an
`\InvalidArgumentException`.

```php
echo Roman::toRoman(4000);
//InvalidArgumentException
```

## To integer

```php
echo Roman::toInt('MXCVII');
//1097

echo Roman::toInt('XCI');
//91
```
