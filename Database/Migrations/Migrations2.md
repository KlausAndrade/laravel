# Migrations
```php
Um user pode ter muitas permissions
Um user pode ter muitas roles
Uma role pode ter muitos users e 
Permission pode ter muitos users
```

Algumas anotações importantes

Para implementar o código default do laravel para suportar ACL devemos alterar a migration users, adicionando o campo string('role');
Que conterá as roles: admin, autor, comun, etc como enum?
```php
class AddRoleToUsersTable extends Migration
{

    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
}
```

Precisamos criar um relacionamento many to many no model User
```php
public function up()
    {
       Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email',191)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
    });
}

    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name'); // edit posts
            $table->string('slug'); //edit-posts
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('permissions');
    }

    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name'); // edit posts
            $table->string('slug'); //edit-posts
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('roles');
    }
```
Tabela pivo
```php
php artisan make:migration create_users_permissions_table --create=users_permissions

    public function up()
    {
        Schema::create('users_permissions', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('permission_id');

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
 
            //SETTING THE PRIMARY KEYS
            $table->primary(['user_id','permission_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('users_permissions');
    }

php artisan make:migration create_users_roles_table --create=users_roles

    public function up()
    {
        Schema::create('users_roles', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('role_id');

         //FOREIGN KEY CONSTRAINTS
           $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
           $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

         //SETTING THE PRIMARY KEYS
           $table->primary(['user_id','role_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('users_roles');
    }
```
Under a particular Role, User may have specific Permission

For example, a user may have the permission for post a topic, and an admin may have the permission to edit or delete a topic. In this case, let’s setup a new table for roles_permissions to handle this complexity.
```php
php artisan make:migration create_roles_permissions_table --create=roles_permissions

    public function up()
    {
        Schema::create('roles_permissions', function (Blueprint $table) {
             $table->unsignedInteger('role_id');
             $table->unsignedInteger('permission_id');

             //FOREIGN KEY CONSTRAINTS
             $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
             $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');

             //SETTING THE PRIMARY KEYS
             $table->primary(['role_id','permission_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('roles_permissions');
    }

php artisan migrate
```
