## Laravel Email Rule

`composer require panda-zoom/laravel-email-rule`;

By default, Email validated by next rules: `email`, `min:6`, `max:100`.

> ***NOTE:*** if need to disable `min|max` rules call methods as `min(null)|max(null)`

### How to use:
[Example here](https://github.com/PandaZoom/laravel-custom-rule#using)

Also available [addition rules](https://laravel.com/docs/9.x/validation#rule-email):

`enableEmailRuleRFC()`  
`enableEmailRuleStrict()`  
`enableEmailRuleDNS()`  
`enableEmailRuleSpoof()`  
`enableEmailRuleFilter()`  

or enable all addition rules by call method:
`enableAllEmailRules()`
