<?php

/***************************************************************************
 *  robotics.usc.edu/~ekaszubski/php/classes/filtered_side_post.php
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

include_once 'php/classes/side_post.php';

class FilteredSidePost
{
    protected $side_post_;
    protected $title_;
    protected $url_;
    protected $alt_title_;
    protected $post_sections_ = array();

    public function __construct( $title, $alt_title = "", $url = "" )
    {
        if( strlen( $alt_title ) == 0 ) $alt_title = $title;

        $this->title_ = $title;
        $this->alt_title_ = $alt_title;
        $this->url_ = $url;
    }

    public function addSection()
    {
        $args_list = func_get_args();

        foreach( $args_list as $section )
        {
            if( $section instanceof PostSection ) array_push( $this->post_sections_, $section );
        }
    }

    public function apply()
    {
        $args_list = func_get_args();
        $args_size = func_num_args();

        if( $args_size ==1 && is_array( $args_list[0] ) )
        {
            $args_list = $args_list[0];
            $args_size = sizeof( $args_list );
        }

        $limit_posts_num = 0;
        if( is_numeric( $args_list[0] ) && !is_string( $args_list[0] ) )
        {
            $limit_posts_num = $args_list[0] > 1 ? 2 * $args_list[0] - 1 : 1;
            $args_list = array_slice( $args_list, 1 );
            $args_size = sizeof( $args_list );
        }

        $this->side_post_ = new SidePost( $args_size == 0 ? $this->title_ : $this->alt_title_, $this->url_ );

        $exclude_sections = $args_list;

        $num_added_sections = 0;
        \PRINT_DEBUG( "Filtering through " . sizeof( $this->post_sections_ ) . " posts" );
        foreach( $this->post_sections_ as $section )
        {
            if( $limit_posts_num > 0 && $this->side_post_->size() >= $limit_posts_num ) break;

            $exclude_section = false;

            foreach( $exclude_sections as $exclude )
            {
                \PRINT_DEBUG( "Testing exclusion filter: " . $exclude . " against section id: " . $section->getID() );
                if( strcmp( $section->getID(), $exclude ) == 0 )
                {
                    \PRINT_DEBUG( "Matched exclusion filter: " . $exclude . " against section id: " . $section->getID() );
                    $exclude_section = true;
                    break;
                }
            }

            if( !$exclude_section )
            {
                if( $num_added_sections > 0 ) $this->side_post_->addChild( new SidePostSeparator() );
                $this->side_post_->addChild( $section );
                ++$num_added_sections;
            }
        }

        return $this->side_post_;
    }
}

?>
