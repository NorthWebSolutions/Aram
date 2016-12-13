<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Dns
 *
 * @author mrgab
 */
class Dns {
            private $the_site_salt = "9845";
        private $the_site_salt2 = "7756";
        private $keys_v;
            public function crypt_pass( $pass )
        {
            //// usable characters:
            $keys_s = "A, Á, B, C, D, E, É, F, G, H, I, Í, J, K, L, M, N, O, Ó, Ö, Ő, P, Q, R, S, T, U, Ú, Ü, Ű, V, W, X, Y, Z,
			   a, á, b, c, d, e, é, f, g, h, i, í, j, k, l, m, n, o, ó, ö, ő, p, q, r, s, t, u, ú, ü, ű, v, w, x, y, z,
			   1, 2, 3, 4, 5, 6, 7, 8, 9, 0, -, _, +, !, %, /, =, (, ), <, >, #, &, @, {, }";
            $keys_s       = explode( ', ', $keys_s ); // make it to array
            //// The replacing numbers
            $this->keys_v = "30,79,7,22,54,69,16,48,61,75,58,79,10,45,66,61,98,34,53,41,25,37,59,
					41,35,56,89,77,23,24,77,53,3,83,74,57,53,90,5,15,66,63,93,75,8,60,36,7,
					93,89,48,18,27,7,59,61,62,49,38,85,73,39,76,99,14,33,52,4,37,66,70,99,
					60,45,8,20,81,15,13,71,62,31,98,69,90,59,32,40,97,18,14,13,56,89";
            $this->keys_v = explode( ',', $this->keys_v ); // make this to array to
            $keys_f       = array_combine( $keys_s, $this->keys_v );
            $tCp          = chunk_split( $pass, 1, "|" );
            $tCp          = strtr( $tCp, $keys_f );
            $tCp          = explode( "|", $tCp );
            $finale       = 1;
            foreach ( $tCp as $value ) {
                $tCp = $value * $this->the_site_salt;
                $finale += $finale * $tCp;
            }
            $finale   = $finale * $this->the_site_salt2;
            $formated = number_format( $finale, 0, '', '' );
            return $formated;
        }
}
