<?php

/***************************************************************************
 *  robotics.usc.edu/~ekaszubski/php/classes/displayable_content_container.php
 *  --------------------
 *
 *  Copyright (c) 2011, Edward T. Kaszubski ( ekaszubski@gmail.com )
 *  All rights reserved.
 *
 *  Redistribution and use in source and binary forms, with or without
 *  modification, are permitted provided that the following conditions are
 *  met:
 *
 *  * Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 *  * Redistributions in binary form must reproduce the above
 *    copyright notice, this list of conditions and the following disclaimer
 *    in the documentation and/or other materials provided with the
 *    distribution.
 *  * Neither the name of USC nor the names of its
 *    contributors may be used to endorse or promote products derived from
 *    this software without specific prior written permission.
 *
 *  THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 *  "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 *  LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 *  A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 *  OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 *  SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 *  LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 *  DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 *  THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 *  (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 *  OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 **************************************************************************/

include_once 'php/global_settings.php';
\PRINT_DEBUG( "included: " . __FILE__ );

interface iDisplayableContentContainer
{
    function display( $parent_offset );
}

class DisplayableContentContainer
{
    protected $child_containers_ = array();
    protected $internal_id_;
    protected $id_;
    protected $parent_container_;

    public function __construct( $internal_id = '' )
    {
        //$this->id_ = hash( "md5", $child_id_ . ++$DisplayableContentContainer_id_ );

        $this->assignInternalID( $internal_id );
        $this->generateID();
    }

    protected function assignInternalID( $internal_id )
    {
        if( isset( $this->internal_id_ ) )
        {
            \PRINT_DEBUG( "Internal id set: " . $this->internal_id_ );
            return;
        }

        if( strlen( $internal_id ) == 0 ) $this->internal_id_ = $this->generateUniqueInternalID();
        else $this->internal_id_ = $internal_id . get_class( $this );

        \PRINT_DEBUG( "Assigned new internal id: " . $this->internal_id_ );
    }

    public function generateUniqueInternalID( $base = 'unnamed' )
    {
        global $DisplayableContentContainer_id_;
        return $base . ++$DisplayableContentContainer_id_ . get_class( $this );
    }

    public function addChild()
    {
        $arg_list = func_get_args();

        \PRINT_DEBUG( "Adding " . sizeof( $arg_list ) . " new children" );

        foreach( $arg_list as $arg )
        {
            if( $arg instanceof DisplayableContentContainer )
            {
                $arg->parent_container_ = &$this;
                $arg->generateID( $this->id_ );
                \PRINT_DEBUG( "Adding: " . $arg->id_ );
                \PRINT_DEBUG( "----------" );
                array_push( $this->child_containers_, $arg );
            }
            else \PRINT_DEBUG( "Ignoring non- DisplayableContentContainer" );
        }
    }

    public function generateID( $parent_id = '' )
    {
        if( isset( $this->id_ ) )
        {
            \PRINT_DEBUG( "ID set: " . $this->id_ );
            return;
        }

        $this->assignInternalID();
        $this->id_ = hash( "md5", $parent_id . $this->internal_id_ );

        \PRINT_DEBUG( "Assigned new id: " . $this->id_ );
    }

    /*public function generateID( $level = 0 )
    {
        global $TAB;
        $offset = str_repeat( $TAB, $level );
        \PRINT_DEBUG( $offset . "Generating id_ [ " . get_class( $this ) . " ]..." );

        if( strlen( $this->internal_id_ ) == 0 )
        {
            \PRINT_DEBUG( $offset . "This item has no internal id; generating..." );
            global $DisplayableContentContainer_id_;
            $this->internal_id_ = "empty" . ++$DisplayableContentContainer_id_;
        }

        if( !isset( $this->parent_container_ ) )
        {
            \PRINT_DEBUG( $offset . "This item has no parent." );
            if( !isset( $this->id_ ) )
            {
                $this->id_ = hash( "md5", $this->internal_id_ );
                \PRINT_DEBUG( $offset . "id generated: " . $this->id_ );
            }
            else \PRINT_DEBUG( $offset . "id fetched: " . $this->id_ );

            return $this->id_;
        }
        else
        {
            \PRINT_DEBUG( $offset . "Fetching parent id..." );
           if( !isset( $this->id_ ) )  $this->id_ = hash( "md5", $this->internal_id_ . $this->getParent()->generateID( $level + 1 ) );
        }

        \PRINT_DEBUG( $offset . "id_ generated: " . $this->id_ );
        return $this->id_;
    }*/

    public function &getParent()
    {
        return $this->parent_container_;
    }

    public function &getChild()
    {
        $arg_list = func_get_args();
        $arg_len = func_num_args();

        $index = $arg_len > 0 ? $arg_list[0] : sizeof( $this->child_containers_ ) - 1;
        return $this->child_containers_[$index];
    }

    public function &getChildren()
    {
        return $this->child_containers_;
    }

    public function size()
    {
        return sizeof( $this->child_containers_ );
    }

    public static function printWithOffset()
    {
        $arg_len = func_num_args();
        if( $arg_len < 1 )
        {
            echo '';
            return;
        }

        $arg_list = func_get_args();

        $offset = $arg_list[0];

        if( $arg_len < 2 )
        {
            echo $offset;
            return;
        }

        $lines = array_slice( $arg_list, 1 );
        foreach( $lines as $line )
        {
            if( $line instanceof DisplayableContentContainer ) $line->display( $offset );
            else echo $offset . $line . "\n";
        }
    }

    public function displayChildren()
    {
        $arg_len = func_num_args();
        $arg_list = func_get_args();

        $parent_offset = $arg_len > 0 ? $arg_list[0] : '';
        $start_index = $arg_len > 1 ? $arg_list[1] : 0;
        $end_index = $arg_len > 2 ? $arg_list[2] + $start_index : sizeof( $this->child_containers_ ) - $start_index;

        for( $i = $start_index; $i < $end_index; ++$i )
        {
            $this->child_containers_[$i]->display( $parent_offset );
        }
    }

    public function getID()
    {
        return $this->id_;
    }

    public function getInternalID()
    {
        return $this->internal_id_;
    }
}

?>
