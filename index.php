<?php

header('Content-Type: application/json');

$allowResourceTypes = [
    'books',
    'authors',
    'genres',
    'types'
];

$resourceType = $_GET['resource_type'];

if(!in_array($allowResourceTypes, $resourceType)){
    http_response_code( 404 );
    echo json_encode(
        [
            'error' => "$resourceType is un unkown",
        ]
    );
    die;
}

$books = [
    1 => [
        'title' => 'EL CASTILLO DE BARBAZUL',
        'authors' => 'JAVIER CERCAS',
        'genres' => 'Novela negra | Novela de policias',
        'n_pages' => 400,
        'cover' => 'https://planetadelibrosco5.cdnstatics.com/usuaris/libros/fotos/351/m_prensa/350298_el-castillo-de-barbazul_9788411070843_3d_202203020907.png',
    ],
    2 => [
        'title' => 'LA SEXTA TRAMPA',
        'authors' => 'J.D BARKER',
        'genres' => 'Novela negra',
        'n_pages' => 608,
        'cover' => 'https://planetadelibrosco5.cdnstatics.com/usuaris/libros/fotos/320/m_prensa/319636_la-sexta-trampa_9788423357628_3d.png',
    ],

    3 => [
        'title' => 'LA QUINTA VICTIMA',
        'authors' => 'J.D BARKER',
        'genres' => 'Novela negra',
        'n_pages' => 608,
        'cover' => 'https://planetadelibrosco5.cdnstatics.com/usuaris/libros/fotos/307/m_prensa/306859_la-quinta-victima_9788423355686_3d.png',
    ],

    4 => [
        'title' => 'EL CUARTO MONO',
        'authors' => 'J.D BARKER',
        'genres' => 'Novela negra',
        'n_pages' => 560,
        'cover' => 'https://planetadelibrosco2.cdnstatics.com/usuaris/libros/fotos/275/original/portada_el-cuarto-mono_jd-barker_201805312309.jpg'
    ]
];

$resourceId = array_key_exists('resource_id', $_GET) ?
$_GET['resource_id'] : '';
$method = $_SERVER['REQUEST_METHOD'];

switch( strtoupper( $method )){
    case 'GET':
        if( "books" !== $resourceType ){
            http_response_code( 404 );

            echo json_encode(
                [
                    'error' => $resourceType. ' not yet implemented :(',
                ]
            );
            die;
        }
        if(!empty($resourceId)){
            if(array_key_exists($resourceId, $book)){
                echo json_encode(
                    $books[ $resourceId ]
                );
            }else {
                http_response_code( 404 );
                echo json_encode(
                    [
                        'error' => 'Book  .$resourceId no found :(',
                    ]
                );
            }
        }else{
            echo json_encode(
                $books
            );
        }
        die;
        break;
    case 'POST':
        $json = file_get_contents('php://input');

        $books[] = json_decode( $json );
        echo array_keys($books)[count($book) -1];
        break;
    case 'PUT':
        if(!empty($resourceId) && array_key_exists($resourceId, $books)){
            $json = file_get_contents('php://input');

            $books[ $resourceId ] = json_decode( $json, true );
            echo $resourceId;
        }
        break;
    case 'DEL':
        if(!empty($resourceId) && array_key_exists( $resourceId, $book )){
            unset($books[$resourceId]);
        }
        break;
        default:
            http_response_code( 404 );
            echo json_encode(
                [
                    'error' => $method. ' not yet implement :('
                ]
            );
            break;
}