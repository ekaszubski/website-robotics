<?php

/***************************************************************************
 *  robotics.usc.edu/~ekaszubski/php/classes/side_post.php
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

include_once 'php/classes/post.php"';

class SidePostSeparator extends DisplayableContentContainer implements iDisplayableContentContainer
{
    public function display( $parent_offset )
    {
        $this->printWithOffset( $parent_offset,
        '<hr />' );
    }
}

class SidePostSection extends PostSection implements iDisplayableContentContainer
{
    public function __construct()
    {
        parent::__construct( func_get_args() );
    }

    public function display( $parent_offset )
    {
        global $TAB;

        if( strlen( $this->getTitleHtml() ) > 0 )
        {
            $this->printWithOffset( $parent_offset,
            '<div class="subsection" id="' . $this->getID() . '">',
            $TAB . '<h3>' . $this->getTitleHtml() . '</h3>' );
        }

        $this->displayChildren(
        $TAB . $parent_offset );

        if( strlen( $this->getTitleHtml() ) > 0 )
        {
            $this->printWithOffset( $parent_offset,
            '</div>' );
        }
    }
}

class SidePost extends Post implements iDisplayableContentContainer
{
    public function __construct()
    {
        parent::__construct( func_get_args() );
    }

    public function display( $parent_offset )
    {
        global $TAB;

        $this->printWithOffset( $parent_offset,
        '<div class="section" id="' . $this->getID() . '">',
        $TAB . '<div class="page-header">',
        $TAB . $TAB . '<h1>' . $this->getTitleHtml() . '</h1>',
        $TAB . '</div> <!-- page header -->' );

        $this->displayChildren(
        $TAB . $parent_offset );

        $this->printWithOffset( $parent_offset,
        '</div>' );
    }
}

/*
$test_side_post = new SidePostSection( new HtmlLink( 'TestSidePost' ), 'content' );
print( "[" . $test_side_post->getTitleHtml() . "]\n" );
*/

?>
