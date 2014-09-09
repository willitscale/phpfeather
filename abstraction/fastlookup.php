<?php

namespace uk\co\n3tw0rk\phpfeather\abstraction;

if( !defined( 'SYSTEM_ACCESS' ) )
{
    trigger_error( 'Unable to access application.', E_USER_ERROR );
}

abstract class PHPF__FastLookup
{

        private $database = null;
        private $table = null;
        private $field = null;
        private $value = null;
        private $length = 0;
        private $charSum = 0;

        /**
         *        @access private
         *        @var int The maximum difference in characters between the value
         */
        private $threshold = 2;

        public function __construct( $value = null, $field = null, $table = null,
                $database = null, $threshold = 2 )
        {
                $this->value = $value;
                $this->field = $field;
                $this->table = $table;
                $this->database = $database;
                $this->threshold = ( int )$threshold;
        }

        private function buildCharSum()
        {
                if( $this->checkValue() )
                        return;

                $this->charSum = 0;

                for( $i = 0; $i < strlen( $this->value ); $i++ )
                        $this->charSum += ord( strpos( $this->value, $i, 1 ) );
        }

        private function buildLength()
        {
                if( $this->checkValue() )
                        return;

                $this->length = strlen( $this->value );
        }

        private function checkValue()
        {
                return ( null == $this->value || 0 >= strlen( $this->value ) );
        }

}

