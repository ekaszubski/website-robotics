<?php

/***************************************************************************
 *  robotics.usc.edu/~ekaszubski/php/classes/nav.php
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

class NavItem extends DisplayableContentContainer implements iDisplayableContentContainer
{
    protected $link_;
    protected $selected_;

    function __construct( $link )
    {
        $this->link_ = $link;
        $this->selected_ = false;
    }

    function setSelected( $is_selected = true )
    {
        $this->selected_ = $is_selected;
    }

    function display( $parent_offset )
    {
        global $TAB;

        if( $this->size() == 0 )
        {
            if( strcmp( $this->link_->getTitle(), 'DIVIDER' ) == 0 )
            {
                $this->printWithOffset( $parent_offset,
                '<li class="' . $this->link_->getClass() . '"></li>' );
            }
            else
            {
                $class = $this->selected_? ' class="active"' : '';

                $this->printWithOffset( $parent_offset,
                '<li' . $class . '>' . $this->link_->getHtml() . '</li>' );
            }
        }
        else
        {
            $this->printWithOffset( $parent_offset,
            '<li class="dropdown">',
            $TAB . '<a href="#"',
            $TAB . $TAB . 'class="dropdown-toggle"',
            $TAB . $TAB . 'data-toggle="dropdown">',
            $TAB . $TAB . $this->link_->getTitle(),
            $TAB . $TAB . '<b class="caret"></b>',
            $TAB . '</a>',
            $TAB . '<ul class="dropdown-menu">' );

            $this->displayChildren(
            $TAB . $TAB . $parent_offset );

            $this->printWithOffset( $parent_offset,
            $TAB . '</ul>',
            '</li>' );
        }
    }
}

class NavItemSection extends DisplayableContentContainer implements iDisplayableContentContainer
{
    protected $alignment_;

    public function __construct( $alignment = '' )
    {
        $this->alignment_ = $alignment;
    }

    public function display( $parent_offset )
    {
        global $TAB;

        $alignment = $this->alignment_;
        if( strlen( $this->alignment_ ) > 0 )
        {
            if( strcmp( $this->alignment_, 'left' ) == 0 ) $alignment = ' pull-left';
            if( strcmp( $this->alignment_, 'right' ) == 0 ) $alignment = ' pull-right';
        }

        $this->printWithOffset( $parent_offset,
        '<ul class="nav nav-pills' . $alignment . '">' );

        $this->displayChildren(
        $TAB . $parent_offset );

        $this->printWithOffset( $parent_offset,
        '</ul>' );
    }
}


class NavElem extends DisplayableContentContainer implements iDisplayableContentContainer
{
    protected $nav_section_;

    public function __construct()
    {
        /*$arg_list = func_get_args();

        foreach( $arg_list as $nav_item )
        {
            $this->addChild( $nav_item );
        }*/

        //$this->addChild( new NavItemSection( 'left' ) );
        //$this->left_nav_section_ = &$this->child_containers_[$this->size() - 1];

        $this->addChild( new NavItemSection() );
        $this->nav_section_ = &$this->child_containers_[$this->size() - 1];
    }

    public function display( $parent_offset )
    {
        global $TAB;

        //$posts = array();
        //              BannerElem   PageElem
        $main_posts = $this->getParent()->getParent()->getMainContent()->getPosts();
        $side_posts = $this->getParent()->getParent()->getSideContent()->getPosts();

        $posts = array_merge( $main_posts, $side_posts );

        // Post
        foreach( $posts as $post )
        {
            if( !( $post instanceof Post ) ) continue;

            $current_title = $post->getTitle();
            $current_id = $post->getID();

            $current_nav_item = new NavItem( new HtmlLink( $current_title ) );

            $sections = &$post->getSections();

            // PostSection
            foreach( $sections as $section )
            {
                if( $section instanceof PostSection )
                {
                    if( strlen( $section->getLink()->getUrl() ) > 0 )
                    {
                        if( $current_nav_item->size() == 0 )
                        {
                            $current_nav_item->addChild( new NavItem( new HtmlLink( $current_title, 'link:#' . $current_id ) ) );
                            $current_nav_item->addChild( new NavItem( new HtmlLink( 'DIVIDER', 'class:divider' ) ) );
                        }
                        $current_nav_item->addChild( new NavItem( $section->getLink() ) );
                    }

                    $subsections = &$section->getContent();

                    foreach( $subsections as $subsection )
                    {
                        if( $subsection instanceof HtmlLink /*&& strlen( $subsection->getUrl() ) > 0*/ )
                        {
                            if( $current_nav_item->size() == 0 )
                            {
                                $current_nav_item->addChild( new NavItem( new HtmlLink( $current_title, 'link:#' . $current_id ) ) );
                                $current_nav_item->addChild( new NavItem( new HtmlLink( 'DIVIDER', 'class:divider' ) ) );
                            }
                            $current_nav_item->addChild( new NavItem( $subsection ) );
                        }
                    }
                }
            }

            if( $current_nav_item->size() == 0 ) $current_nav_item = new NavItem( new HtmlLink( $current_title, 'link:#' . $current_id ) );


            $this->nav_section_->addChild( $current_nav_item );

            /*if( $post->size() > 0 )
            {
                $current_nav_item->addChild( new NavItem( $current_title, '#' . $current_id ) );
                $current_nav_item->addChild( new NavItem( 'DIVIDER' ) );
            }

            $sections = &$post->getSections();
            foreach( $sections as $section )
            {
                if( $section instanceof MainPostSection )
                {
                    $current_nav_item->addChild( new NavItem( $section->getTitle(), '#' . $section->getID() ) );
                }
            }*/

            //$this->left_nav_section_->addChild( $current_nav_item );
        }

        if( $this->size() > 0 )
        {
            $this->printWithOffset( $parent_offset,
            '<div class="subnav">' );

            $this->displayChildren(
            $TAB . $parent_offset );

            $this->printWithOffset( $parent_offset,
            '</div>' );
        }
    }
}

?>
