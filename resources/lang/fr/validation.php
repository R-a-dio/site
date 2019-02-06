<?php

return array(

        /*
        |--------------------------------------------------------------------------
        | Validation Language Lines
        |--------------------------------------------------------------------------
        |
        | The following language lines contain the default error messages used by
        | the validator class. Some of these rules have multiple versions such
        | such as the size rules. Feel free to tweak each of these messages.
        |
        */

        "accepted" => ":attribute doit être accepté.",
        "active_url" => ":attribute n'est pas une URL valide.",
        "after" => ":attribute doit être une date après :date.",
        "alpha" => ":attribute ne peut contenir que des lettres.",
        "alpha_dash" => ":attribute ne peut contenir que des lettres, des nombres et des tirets.",
        "alpha_num" => ":attribute ne peut contenir que des lettres et des nombres.",
        "array" => ":attribute doit être un array.",
        "before" => ":attribute doit être une date avant :date.",
        "between" => array(
                "numeric" => ":attribute doit être entre :min et :max.",
                "file" => ":attribute doit faire entre :min et :max kilo-octets.",
                "string" => ":attribute doit contenir entre :min et :max caractères.",
                "array" => ":attribute doit avoir entre :min et :max objets.",
        ),
        "confirmed" => "La confirmation de :attribute ne correspond pas.",
        "date" => ":attribute n'est pas une date valide.",
        "date_format" => ":attribute ne correspond pas au format :format.",
        "different" => ":attribute et :other doivent être différents.",
        "digits" => ":attribute doit avoir :digits chiffres.",
        "digits_between" => ":attribute doit comprendre entre :min et :max chiffres.",
        "email" => "Le format de :attribute est invalide.",
        "exists" => ":attribute séléctionné est invalide.",
        "image" => ":attribute doit être une image.",
        "in" => ":attribute sélectionné est invalide.",
        "integer" => ":attribute doit être un integer.",
        "ip" => ":attribute doit être une adresse IP valide.",
        "max" => array(
                "numeric" => ":attribute ne peut pas être plus grand que :max.",
                "file" => ":attribute ne peut pas être plus grand que :max kilo-octets.",
                "string" => ":attribute ne peut pas contenir plus de :max caractères.",
                "array" => ":attribute ne peut pas contenir plus de :max objets.",
        ),
        "mimes" => ":attribute doit être un fichier de type: :values.",
        "min" => array(
                "numeric" => ":attribute doit être au moins :min.",
                "file" => ":attribute doit faire au moins :min kilo-octets.",
                "string" => ":attribute doit contenir au moins :min caractères.",
                "array" => ":attribute doit avoir au moins :min objets.",
        ),
        "not_in" => ":attribute sélectionné est invalide.",
        "numeric" => ":attribute doit être un nombre.",
        "regex" => "Le format de :attribute est invalide.",
        "required" => "Le champ :attribute est requis.",
        "required_if" => "Le champ :attribute est requis lorsque :other est :value.",
        "required_with" => "Le champ :attribute est requis lorsque :values est présent.",
        "required_without" => "Le champ :attribute est requis lorsque :values n'est pas présent.",
        "same" => ":attribute et :other doivent correspondre.",
        "size" => array(
                "numeric" => ":attribute doit faire :size.",
                "file" => ":attribute doit faire :size kilo-octets.",
                "string" => ":attribute doit contenir :size caractères.",
                "array" => ":attribute doit contenir :size objets.",
        ),
        "unique" => ":attribute est déjà pris.",
        "url" => "Le format de :attribute est invalide.",

        /*
        |--------------------------------------------------------------------------
        | Custom Validation Language Lines
        |--------------------------------------------------------------------------
        |
        | Here you may specify custom validation messages for attributes using the
        | convention "attribute.rule" to name the lines. This makes it quick to
        | specify a specific custom language line for a given attribute rule.
        |
        */

        'custom' => array(),

        /*
        |--------------------------------------------------------------------------
        | Custom Validation Attributes
        |--------------------------------------------------------------------------
        |
        | The following language lines are used to swap attribute place-holders
        | with something more reader friendly such as E-Mail Address instead
        | of "email". This simply helps us make messages a little cleaner.
        |
        */

        'attributes' => array(),

);