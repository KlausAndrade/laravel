# Nomes de tabelas

Simples - plural
```php
users
roles
permissions
```

Compostas_pivô - compsoto por dois nomes, separados por _ e ambos no singular
```php
user_role
user_permission
role_permission

// in Product model
public function features()
{
    return $this->belongsToMany('App\Feature', 'product_feature');
}

// in Feature model
public function products()
{
    return $this->belongsToMany('App\Product', 'product_feature');
}
```

