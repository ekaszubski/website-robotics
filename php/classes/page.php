<?php

/***************************************************************************
 *  robotics.usc.edu/~ekaszubski/php/classes/page.php
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

include_once 'php/classes/main_post.php';
include_once 'php/classes/side_post.php';
include_once 'php/classes/plain_section.php';
include_once 'php/classes/nav.php';

class BannerElem extends DisplayableContentContainer implements iDisplayableContentContainer
{
    protected $title_;
    protected $subtitle_;
    protected $subnav_elem_;

    public function __construct( $title, $subtitle )
    {
        $this->title_ = $title;
        $this->subtitle_ = $subtitle;

        $this->addChild( new NavElem() );
        $this->subnav_elem_ = &$this->child_containers_[$this->size() - 1];
    }

    public function &getSubnav()
    {
        return $this->subnav_elem_;
    }

    public function display( $parent_offset )
    {
        global $TAB;

        //                   PageElem     BodyElem     PageGenerator
        $head_elem = &$this->getParent()->getParent()->getParent()->getHead();

        $this->printWithOffset( $parent_offset,
        '<!-- Masthead',
        '================================================== -->',
        '<header class="jumbotron subhead" id="overview">',
        $TAB . '<h1>' . $head_elem->getTitle() . '</h1>',
        $TAB . '<p class="lead">' . $head_elem->getSubtitle() . '</p>' );

        $this->displayChildren(
        $TAB . $parent_offset );

        $this->printWithOffset( $parent_offset,
        '</header>' );
    }
}

abstract class _ContentElem extends DisplayableContentContainer
{
    public function __construct()
    {

    }

    public function &getPosts()
    {
        return $this->child_containers_;
    }
}

class MainContentElem extends _ContentElem implements iDisplayableContentContainer
{
    public function __construct()
    {
        parent::__construct();
    }

    public function display( $parent_offset )
    {
        global $TAB;

        $this->printWithOffset( $parent_offset,
        '<div class="span8">' );

        $this->displayChildren(
        $TAB . $parent_offset );

        $this->printWithOffset( $parent_offset,
        '</div>' );
    }
}

class SideContentElem extends _ContentElem implements iDisplayableContentContainer
{
    public function __construct()
    {
        parent::__construct();
    }

    public function display( $parent_offset )
    {
        global $TAB;

        $this->printWithOffset( $parent_offset,
        '<div class="span4">' );

        $this->displayChildren(
        $TAB . $parent_offset );

        $this->printWithOffset( $parent_offset,
        '</div>' );
    }
}

class ContentContainerElem extends DisplayableContentContainer implements iDisplayableContentContainer
{
    protected $main_content_elem_;
    protected $side_content_elem_;

    public function __construct()
    {
        $this->addChild( new MainContentElem() );
        $this->main_content_elem_ = &$this->child_containers_[$this->size() - 1];

        $this->addChild( new SideContentElem() );
        $this->side_content_elem_ = &$this->child_containers_[$this->size() - 1];
    }

    public function &getMainContent()
    {
        return $this->main_content_elem_;
    }

    public function &getSideContent()
    {
        return $this->side_content_elem_;
    }

    public function display( $parent_offset )
    {
        global $TAB;

        $this->printWithOffset( $parent_offset,
        '<div class="row">' );

        $this->displayChildren(
        $TAB . $parent_offset );

        $this->printWithOffset( $parent_offset,
        '</div>' );
    }
}

class FooterElem extends DisplayableContentContainer implements iDisplayableContentContainer
{
    public function __construct()
    {
        parent::__construct();
    }

    public function display( $parent_offset )
    {
        global $TAB;

        $this->printWithOffset( $parent_offset,
        '<!-- Footer',
        '================================================== -->',
        '<footer class="footer">',
        $TAB . '<p class="pull-right"><a href="#">Back to top</a></p>',
        $TAB . '<p>Built with <a href="http://twitter.github.com/bootstrap" target="_blank">bootstrap</a></a>.</p>',
        '</footer>' );
    }
}

class PageElem extends DisplayableContentContainer implements iDisplayableContentContainer
{
    protected $banner_elem_;
    protected $content_elem_;
    protected $footer_elem_;

    public function __construct()
    {
        $this->addChild( new BannerElem() );
        $this->banner_elem_ = &$this->child_containers_[$this->size() - 1];

        $this->addChild( new ContentContainerElem() );
        $this->content_elem_ = &$this->child_containers_[$this->size() - 1];

        $this->addChild( new FooterElem() );
        $this->footer_elem_ = &$this->child_containers_[$this->size() - 1];
    }

    public function &getBanner()
    {
        return $this->banner_elem_;
    }

    public function &getContent()
    {
        return $this->content_elem_;
    }

    public function &getMainContent()
    {
        return $this->content_elem_->getMainContent();
    }

    public function &getSideContent()
    {
        return $this->content_elem_->getSideContent();
    }

    public function &getFooter()
    {
        return $this->footer_elem_;
    }

    public function display( $parent_offset )
    {
        global $TAB;

        $this->printWithOffset( $parent_offset,
        '<div class="container">' );

        $this->displayChildren(
        $TAB . $parent_offset );

        $this->printWithOffset( $parent_offset,
        '</div> <!-- container -->' );
    }
}

?>
