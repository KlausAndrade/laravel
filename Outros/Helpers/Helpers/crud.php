<?php

/**
 * select
 * Consulta o banco de dados e retorna o registro de acordo com o id recebido
 * usage: Exemplo de uso: return select(3,'users');
 * @param  mixed $table
 * @param  mixed $id
 * @return void
 */
function select($table = 'users', $id): void
{

    // Consultar se existe o id indicado
    $exists = DB::table($table)->select('id')
        ->where('id', $id)
        ->first();

    if ($exists) {
        echo "Existe um user com o id: {$id}";
        return;
    }

    echo "Não existe um user com o id: {$id}";
}

// Exemplo de uso: return select(3,'users');

function insert($table = 'users', $fields = [])
{ // Ex: $fields = ['name' => 'Ribamar FS', 'email' => 'ribafs@gmail.com'];

    DB::table($table)->insert(
        $fields
    );
    echo 'Registro adicionado com sucesso ';
}
// Exemplo de uso: return insert('users', ['name' => 'Ribamar FS', 'email' => 'joao@gmail.com', 'password' => bcrypt('123456')]);

function update($table = 'users', $whereValue, $fields = [])
{ // Ex: 'users', ['id', 2], ['name' => 'João Brito']

    // Consultar se existe o registro através do $whereValue
    $id = DB::table($table)->select('id')->where('id', $whereValue)->first();

    // Caso exista, atualizar
    if (!is_null($id)) {
        $affected = DB::table($table)
            ->where('id', $whereValue)
            ->update($fields);
        echo 'Client com id: ' . $whereValue . ' atualizado com sucesso';
    } else {
        echo 'Não existe client com este id: ' . $whereValue;
    }
}
// Exemplos de uso:
// return update('users', 5, ['name' => 'João Brito']);
// return update('users', 5, ['name' => 'João Brito', 'email' => 'joao@joao.org']);

function delete($table, $id)
{

    // Consultar se o registro com $id existe
    $id2 = DB::table($table)->select('id')->where('id', $id)->first();

    // Caso exista
    if (!is_null($id2)) {
        $affected = DB::table($table)
            ->where('id', $id)
            ->delete();
        echo 'Registro com id: ' . $id . ' excluído com sucesso';
    } else {
        echo 'Não existe registro com este id: ' . $id;
    }
}
// Exemplo de uso: return delete('users', 5);
