<?php

/***************************************************************************
 *  robotics.usc.edu/~ekaszubski/php/classes/post.php
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

include_once 'php/classes/displayable_content_container.php';

class HtmlLink extends DisplayableContentContainer implements iDisplayableContentContainer
{
    protected $title_;
    protected $target_;
    protected $url_;
    protected $html_;
    protected $class_;

    public function __construct()
    {
        global $TAB;

        $args_list = func_get_args();
        $args_num = func_num_args();

        if( $args_num == 1 && is_array( $args_list[0] ) )
        {
            $args_list = $args_list[0];
            $args_num = sizeof( $args_list );
        }

        if( $args_num == 1 )
        {
            if( is_string( $args_list[0] ) )
            {
                $this->title_ = $args_list[0];
                $this->html_ = $this->title_;
                parent::__construct( $this->title_ );
            }
        }
        else if( $args_num > 1 && is_string( $args_list[0] ) )
        {
            $this->title_ = $args_list[0];

            $id = $this->title_;
            $link = '';
            $target = '';

            $arg_index = 1;
            $remaining_args = array_slice( $args_list, $arg_index );
            foreach( $remaining_args as $arg )
            {
                if( !is_string( $arg ) ) continue;

                $tag_content = preg_replace( "/^id:/", "", $arg  );
                if( strcmp( $tag_content, $arg ) )
                {
                    $id = $tag_content;
                    ++$arg_index;
                    continue;
                }

                $tag_content = preg_replace( "/^class:/", "", $arg  );
                if( strcmp( $tag_content, $arg ) )
                {
                    $this->class_ = $tag_content;
                    ++$arg_index;
                    continue;
                }

                $tag_content = preg_replace( "/^link:/", "", $arg  );
                if( strcmp( $tag_content, $arg ) )
                {
                    $link = $tag_content;
                    if( substr( $link, 0, 1 ) == "/" )
                    {
                        global $SITE_ROOT;
                        $link = $SITE_ROOT . $link;
                    }
                    ++$arg_index;
                    continue;
                }

                $tag_content = preg_replace( "/^target:/", "", $arg  );
                if( strcmp( $tag_content, $arg ) )
                {
                    $target = $tag_content;
                    ++$arg_index;
                    continue;
                }

                break;
            }

            parent::__construct( $id );
//            $this->generateID();

            if( $link != "" )
            {
                $this->html_ = '<a' . ( strlen( $class ) > 0 ? ' class="' . $class . '"' : '' ) . ( strlen( $target ) > 0 ? ' target="' . $target . '"' : '' ) . ' href="' . $link . '">' . $this->title_ . '</a>';
                $this->url_ = $link;
                $this->target_ = $target;
            }
            else $this->html_ = $this->title_;
        }

        //print( "made new HtmlLink: [" . $this->getHtml() . "]\n" );
    }

    public function display( $parent_offset )
    {
        $this->printWithOffset( $parent_offset,
        $this->html_ );
    }

    public function &getTitle()
    {
        return $this->title_;
    }

    public function &getUrl()
    {
        return $this->url_;
    }

    public function &getTarget()
    {
        return $this->target_;
    }

    public function &getClass()
    {
        return $this->class_;
    }

    public function &getHtml()
    {
        return $this->html_;
    }
}

class PostSectionLine extends DisplayableContentContainer implements iDisplayableContentContainer
{
    protected $line_;

    public function __construct( $line )
    {
        $this->line_ = $line;
    }

    public function &getLine()
    {
        return $this->line_;
    }

    public function display( $parent_offset )
    {
        $this->printWithOffset( $parent_offset,
        $this->line_ );
    }
}

abstract class PostSection extends DisplayableContentContainer
{
    protected $link_;

    public function __construct()
    {
        global $TAB;

        $args_list = func_get_args();
        $args_num = func_num_args();

        if( $args_num ==1 && is_array( $args_list[0] ) )
        {
            $args_list = $args_list[0];
            $args_num = sizeof( $args_list );
        }

        //print_r( $args_list );

        if( $args_num > 0 )
        {
            if( is_string( $args_list[0] ) )
            {
                $this->link_ = new HtmlLink( $args_list[0] );
            }
            else if( $args_list[0] instanceof HtmlLink )
            {
                //print( "copying title from HtmlLink\n" );
                $this->link_ = $args_list[0];
            }

            parent::__construct( $this->getTitle() );
        }

        if( $args_num > 1 )
        {
            $arg_index = 1;
            $remaining_args = array_slice( $args_list, $arg_index );
            foreach( $remaining_args as $arg )
            {
                if( $arg instanceof DisplayableContentContainer )
                {
                    $this->addChild( $arg );
                    ++$arg_index;
                    continue;
                }
                else if( is_string( $arg ) )
                {
                    $this->addChild( new PostSectionLine( $arg ) );
                    ++$arg_index;
                    continue;
                }
            }

            $remaining_args = array_slice( $args_list, $arg_index );

            if( sizeof( $remaining_args ) == 1 ) $this->appendLines( '<p>', $TAB . $remaining_args[0], '</p>' );
            else $this->appendLines( $remaining_args );
        }
    }

    public function appendLines()
    {
        $args_list = func_get_args();
        $args_num = func_num_args();

        $remaining_args = $args_list;

        if( $args_num ==1 && is_array( $args_list[0] ) )
        {
            $remaining_args = $args_list[0];
        }

        foreach( $remaining_args as $arg )
        {
            $this->addChild( new PostSectionLine( $arg ) );
        }
    }

    public function &getTitle()
    {
        return $this->link_->getTitle();
    }

    public function &getLink()
    {
        return $this->link_;
    }

    public function &getTitleHtml()
    {
        return $this->link_->getHtml();
    }

    public function &getTitleLinkUrl()
    {
        return $this->link_->getUrl();
    }

    public function &getContent()
    {
        return $this->child_containers_;
    }
}

abstract class Post extends DisplayableContentContainer
{
    protected $link_;

    public function __construct()
    {
        $args_list = func_get_args();
        $args_num = func_num_args();

        $args = $args_list;

        if( $args_num == 1 && is_array( $args_list[0] ) )
        {
            $args = $args_list[0];
            $args_num = sizeof( $args );
        }

        $this->link_ = new HtmlLink( $args );

        parent::__construct( $this->link_->getTitle() );
    }

    public function &getTitle()
    {
        return $this->link_->getTitle();
    }

    public function &getTitleHtml()
    {
        return $this->link_->getHtml();
    }

    public function &getLink()
    {
        return $this->link_;
    }

    public function &getUrl()
    {
        return $this->link_->getUrl();
    }

    public function &getSections()
    {
        return $this->child_containers_;
    }
}

class PlainPostSection extends PostSection implements iDisplayableContentContainer
{
    public function __construct()
    {
        $args = func_get_args();
        parent::__construct( $args );
    }

    public function display( $parent_offset )
    {
        global $TAB;

        $this->displayChildren(
        $parent_offset );
    }
}

/*
$test_html_link = new HtmlLink( 'Title' );
$test_html_link = new HtmlLink( 'Title', 'target:_blank' );
$test_html_link = new HtmlLink( 'Title', 'link:/projects' );
$test_html_link = new HtmlLink( 'Title', 'link:http://google.com' );
$test_html_link = new HtmlLink( 'Title', 'link:/projects', 'target:_blank' );
$test_html_link = new HtmlLink( 'Title', 'link:#projects', 'class:something, something_else' );*/

?>
