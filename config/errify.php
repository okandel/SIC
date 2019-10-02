<?php

 return [
   'accepted'             => 1,
   'active_url'           => 1,
   'after'                => 1,
   'alpha'                => 1,
   'alpha_dash'           => 1,
   'alpha_num'            => 1,
   'array'                => 1,
   'before'               => 1,
   'between'              => 1,
   'boolean'              => 1,
   'confirmed'            => 1,
   'date'                 => 1,
   'date_format'          => 1,
   'different'            => 1,
   'digits'               => 1,
   'digits_between'       => 1,
   'email'                => 1,
   'exists'               => 1,
   'filled'               => 1,
   'image'                => 1,
   'in'                   => 1,
   'integer'              => 1,
   'ip'                   => 1,
   'max'                  => 1,
   'mimes'                => 1,
   'min'                  => 1,
   'not_in'               => 1,
   'numeric'              => 1,
   'regex'                => 1,
   'required'             => 1,
   'required_if'          => 1,
   'required_with'        => 1,
   'required_with_all'    => 1,
   'required_without'     => 1,
   'required_without_all' => 1,
   'same'                 => 1,
   'size'                 => 1,
   'string'               => 1,
   'timezone'             => 1,
   'unique'               => 1,
   'url'                  => 1,

   'auth' =>[
      'email_not_found' => 2,

      'email_already_verified' => 3,
      'email_not_verified' => 3,
      
      'invalid_creds' => 2,   
      'invalid_token'=>2, 
    ],

    'client' =>[
        'not_found'=>1404
    ], 
    'clientBranch' =>[
        'not_found'=>1404
    ], 
    'clientRep' =>[
        'not_found'=>1404
    ], 
    'employee' =>[
        'not_found'=>1404
    ],
    'item' =>[
        'not_found'=>1404
    ],
    'mission' =>[
        'not_found'=>1404
    ],
   
    'industry' =>[
        'not_found'=>1404
    ],
    'country' =>[
        'not_found'=>1404
    ],
    'state' =>[
        'not_found'=>1404
    ],
    'city' =>[
        'not_found'=>1404
    ]   
 ];
