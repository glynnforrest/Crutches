# Roman

Convert integers to roman numerals and back again.

## To roman

```php
echo Roman::toRoman(1997);
//'MCMXCVII'

echo Roman::toRoman(148);
//'CXLVIII'
```

## To integer

```php
echo Roman::toInt('MXCVII');
//1097

echo Roman::toInt('XCI');
//91
```
