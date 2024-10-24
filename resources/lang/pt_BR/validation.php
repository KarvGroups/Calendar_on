<?php

return [

    'accepted' => 'O :attribute deve ser aceito.',
    'active_url' => 'O :attribute não é uma URL válida.',
    'after' => 'O :attribute deve ser uma data posterior a :date.',
    'alpha' => 'O :attribute só pode conter letras.',
    'alpha_dash' => 'O :attribute só pode conter letras, números, traços e sublinhados.',
    'alpha_num' => 'O :attribute só pode conter letras e números.',
    'array' => 'O :attribute deve ser um array.',
    'before' => 'O :attribute deve ser uma data anterior a :date.',
    'between' => [
        'numeric' => 'O :attribute deve estar entre :min e :max.',
        'file' => 'O :attribute deve ter entre :min e :max kilobytes.',
        'string' => 'O :attribute deve ter entre :min e :max caracteres.',
        'array' => 'O :attribute deve ter entre :min e :max itens.',
    ],
    'boolean' => 'O campo :attribute deve ser verdadeiro ou falso.',
    'confirmed' => 'A confirmação do :attribute não coincide.',
    'date' => 'O :attribute não é uma data válida.',
    'email' => 'O :attribute deve ser um endereço de e-mail válido.',
    'exists' => 'O :attribute selecionado é inválido.',
    'file' => 'O :attribute deve ser um arquivo.',
    'filled' => 'O campo :attribute deve ter um valor.',
    'image' => 'O :attribute deve ser uma imagem.',
    'in' => 'O :attribute selecionado é inválido.',
    'integer' => 'O :attribute deve ser um número inteiro.',
    'ip' => 'O :attribute deve ser um endereço IP válido.',
    'json' => 'O :attribute deve ser uma string JSON válida.',
    'max' => [
        'numeric' => 'O :attribute não pode ser maior que :max.',
        'file' => 'O :attribute não pode ter mais que :max kilobytes.',
        'string' => 'O :attribute não pode ter mais que :max caracteres.',
        'array' => 'O :attribute não pode ter mais que :max itens.',
    ],
    'mimes' => 'O :attribute deve ser um arquivo do tipo: :values.',
    'mimetypes' => 'O :attribute deve ser um arquivo do tipo: :values.',
    'min' => [
        'numeric' => 'O :attribute deve ser pelo menos :min.',
        'file' => 'O :attribute deve ter pelo menos :min kilobytes.',
        'string' => 'O :attribute deve ter pelo menos :min caracteres.',
        'array' => 'O :attribute deve ter pelo menos :min itens.',
    ],
    'not_in' => 'O :attribute selecionado é inválido.',
    'numeric' => 'O :attribute deve ser um número.',
    'present' => 'O campo :attribute deve estar presente.',
    'regex' => 'O formato do :attribute é inválido.',
    'required' => 'O campo :attribute é obrigatório.',
    'required_if' => 'O campo :attribute é obrigatório quando :other é :value.',
    'required_unless' => 'O campo :attribute é obrigatório, a menos que :other esteja em :values.',
    'required_with' => 'O campo :attribute é obrigatório quando :values está presente.',
    'required_with_all' => 'O campo :attribute é obrigatório quando :values estão presentes.',
    'required_without' => 'O campo :attribute é obrigatório quando :values não está presente.',
    'required_without_all' => 'O campo :attribute é obrigatório quando nenhum dos :values estão presentes.',
    'same' => 'O :attribute e :other devem coincidir.',
    'size' => [
        'numeric' => 'O :attribute deve ter :size.',
        'file' => 'O :attribute deve ter :size kilobytes.',
        'string' => 'O :attribute deve ter :size caracteres.',
        'array' => 'O :attribute deve conter :size itens.',
    ],
    'string' => 'O :attribute deve ser uma string.',
    'timezone' => 'O :attribute deve ser uma zona válida.',
    'unique' => 'O :attribute já está em uso.',
    'uploaded' => 'O :attribute falhou ao ser carregado.',
    'url' => 'O formato do :attribute é inválido.',

    'attributes' => [
        'nomeEmpresa' => 'Nome da Empresa',
        'emailEmpresa' => 'Email da Empresa',
        'enderecoEmpresa' => 'Endereço da Empresa',
        'contactoEmpresa' => 'Contato da Empresa',
        'especializacaoEmpresa' => 'Especialização da Empresa',
        'contribuinteEmpresa' => 'Contribuinte da Empresa',
        'imagemEmpresa' => 'Imagem da Empresa',
        'statusEmpresa' => 'Status da Empresa',
        'linkCalendarEmpresa' => 'Url do calendario de marcação',
        'data_criacaoEmpresa' => 'Data de Criação da Empresa',

        'nomeUsuario' => 'Nome do Usuário',
        'apelidoUsuario' => 'Apelido do Usuário',
        'emailUsuario' => 'Email do Usuário',
        'senhaUsuario' => 'Senha do Usuário',

        'name' => 'Nome do Usuário',
        'apelido' => 'Apelido do Usuário',
        'email' => 'Email do Usuário',
        'contacto' => 'Contacto do Usuário',
        'status' => 'Status do Usuário',
        'nivel' => 'Nivel do Usuário',
        'password' => 'Senha do Usuário',

        'service_ids' => 'Id dos Serviços',

        'serviceTitle' => 'Titulo do Serviço',
        'servicePrice' => 'Preço do serviço',
        'serviceTime' => 'Tempo do Usuário',
        'selectedCategoryId' => 'Id Categoria',
    ],
];
