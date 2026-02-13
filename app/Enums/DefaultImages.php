<?php

namespace App\Enums;

enum DefaultImages: string
{

    CASE DARK_THEME_LOGO = 'https://indoortech.com.br/wp-content/uploads/2022/01/logo3-texto-branco.png';
    CASE LIGHT_THEME_LOGO = 'https://indoortech.com.br/wp-content/uploads/2022/03/fundoTelaPrincipal.png';
    CASE FAV_ICON = 'https://indoortech.com.br/wp-content/uploads/2022/01/cropped-fav.png';

    public function toString(): string
    {
        return $this->value;
    }
}
