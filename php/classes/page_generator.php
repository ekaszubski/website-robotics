<?php

/***************************************************************************
 *  robotics.usc.edu/~ekaszubski/php/classes/page_generator.php
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

include_once 'php/classes/page.php';
include_once 'php/classes/nav.php';
include_once 'php/content/main_menu.php';

class HeadElem extends DisplayableContentContainer implements iDisplayableContentContainer
{
    protected $title_;
    protected $subtitle_;

    public function __construct( $title, $subtitle = "" )
    {
        \PRINT_DEBUG( "Constructing new HeadElem: " . $title );
        parent::__construct( $title );

        $this->title_ = $title;
        $this->subtitle_ = $subtitle;
    }

    public function display( $parent_offset )
    {
        global $SITE_TITLE;
        global $SITE_ROOT;
        global $TAB;

        $this->printWithOffset( $parent_offset,
        '<head>',
        $TAB . '<meta charset="utf-8">',
        $TAB . '<title>' . $this->title_ . ' - ' . $SITE_TITLE . '</title>',
        $TAB . '<meta name="viewport" content="width=device-width, initial-scale=1.0">',
        $TAB . '<!-- styles -->',
        $TAB . '<link href="' . $SITE_ROOT . '/assets/css/bootstrap.css" rel="stylesheet">',
        $TAB . '<link href="' . $SITE_ROOT . '/assets/css/bootstrap-responsive.css" rel="stylesheet">',
        $TAB . '<link href="' . $SITE_ROOT . '/assets/css/docs.css" rel="stylesheet">',
        $TAB . '<link href="' . $SITE_ROOT . '/assets/css/code-prettify.css" rel="stylesheet">',
        $TAB . '<link href="' . $SITE_ROOT . '/assets/css/custom.css" rel="stylesheet">',
        $TAB . '<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->',
        $TAB . '<!--[if lt IE 9]>',
        $TAB . $TAB . '<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>',
        $TAB . '<![endif]-->',
        $TAB . '<!-- fav and touch icons -->',
        $TAB . '<link rel="shortcut icon" href="' . $SITE_ROOT . '/assets/ico/favicon.ico">',
        $TAB . '<link rel="apple-touch-icon-precomposed" sizes="114x114" href="' . $SITE_ROOT . 'assets/ico/apple-touch-icon-114-precomposed.png">',
        $TAB . '<link rel="apple-touch-icon-precomposed" sizes="72x72" href="' . $SITE_ROOT . 'assets/ico/apple-touch-icon-72-precomposed.png">',
        $TAB . '<link rel="apple-touch-icon-precomposed" href="' . $SITE_ROOT . '/assets/ico/apple-touch-icon-57-precomposed.png">',
        '</head>' );
    }

    public function &getTitle()
    {
        return $this->title_;
    }

    public function &getSubtitle()
    {
        return $this->subtitle_;
    }
}

class HeaderElem extends DisplayableContentContainer implements iDisplayableContentContainer
{
    public function __construct()
    {
        \PRINT_DEBUG( "Constructing new HeaderElem" );
        parent::__construct();

        global $SITE_ROOT;
        global $DOMAIN;
        global $DOMAIN_URL;
        global $PARENT_SITE;
        global $PARENT_SITE_URL;

        $this->addChild( new NavItem( new HtmlLink( 'USC Robotics' ) ) );
        foreach( \content\menus\main\usc_robotics() as $menu_item )
        {
            $this->getChild()->addChild( $menu_item );
        }

        $this->addChild( new NavItem( new HtmlLink( 'DIVIDER', 'class:divider-vertical' ) ) );

        $this->addChild( new NavItem( new HtmlLink( 'Home', 'link:/' ) ) );

        $this->addChild( new NavItem( new HtmlLink( 'Research', 'link:/research' ) ) );
        foreach( \content\menus\main\research() as $menu_item )
        {
            $this->getChild()->addChild( $menu_item );
        }

        $this->addChild( new NavItem( new HtmlLink( 'Projects', 'link:/projects' ) ) );
        foreach( \content\menus\main\projects() as $menu_item )
        {
            $this->getChild()->addChild( $menu_item );
        }

        $this->addChild( new NavItem( new HtmlLink( 'Updates', 'link:/updates' ) ) );

        $this->addChild( new NavItem( new HtmlLink( 'Contact', 'link:#' ) ) );
    }

    public function display( $parent_offset )
    {
        global $TAB;
        global $SITE_ROOT;
        global $SITE_NAME;

        $this->printWithOffset( $parent_offset,
        '<!-- Navbar',
        '================================================== -->',
        '<div class="navbar navbar-fixed-top">',
        $TAB . '<div class="navbar-inner">',
        $TAB . $TAB . '<div class="container">',
        $TAB . $TAB . $TAB . '<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">',
        $TAB . $TAB . $TAB . $TAB . '<span class="icon-bar"></span>',
        $TAB . $TAB . $TAB . $TAB . '<span class="icon-bar"></span>',
        $TAB . $TAB . $TAB . $TAB . '<span class="icon-bar"></span>',
        $TAB . $TAB . $TAB . '</a>',
        $TAB . $TAB . $TAB . '<a class="brand" href="' . $SITE_ROOT . '">' . $SITE_NAME . '</a>',
        $TAB . $TAB . $TAB . '<div class="nav-collapse">',
        $TAB . $TAB . $TAB . $TAB . '<ul class="nav">',
        $TAB . $TAB . $TAB . $TAB . $TAB . '<ul class="nav">' );

        $this->displayChildren(
        $TAB . $TAB . $TAB . $TAB . $TAB . $TAB . $parent_offset );

        $this->printWithOffset( $parent_offset,
        $TAB . $TAB . $TAB . $TAB . $TAB . '</ul>',
        $TAB . $TAB . $TAB . $TAB . '</ul>',
        $TAB . $TAB . $TAB . '</div><!--/.nav-collapse -->',
        $TAB . $TAB . '</div>',
        $TAB . '</div>',
        '</div>' );
    }
}

class BodyElem extends DisplayableContentContainer implements iDisplayableContentContainer
{
    // primary menu
    protected $header_elem_;
    // page
    protected $page_elem_;

    public function __construct()
    {
        \PRINT_DEBUG( "Constructing new BodyElem" );
        parent::__construct();

        $this->addChild( new HeaderElem() );
        $this->header_elem_ = &$this->child_containers_[$this->size() - 1];

        $this->addChild( new PageElem() );
        $this->page_elem_ = &$this->child_containers_[$this->size() - 1];
    }

    public function &getHeader()
    {
        return $this->header_elem_;
    }

    public function &getPage()
    {
        return $this->page_elem_;
    }

    public function display( $parent_offset )
    {
        global $TAB;
        global $SITE_ROOT;

        $this->printWithOffset( $parent_offset,
        '<body data-spy="scroll" data-target=".subnav" data-offset="50">' );

        $this->displayChildren(
        $TAB . $parent_offset );

        $this->printWithOffset( $parent_offset,
        $TAB . '<script src="' . $SITE_ROOT . '/assets/js/code-prettify.js"></script>',
        $TAB . '<script src="' . $SITE_ROOT . '/assets/js/jquery.js"></script>',
        $TAB . '<script src="' . $SITE_ROOT . '/assets/js/bootstrap.js"></script>',
        $TAB . '<script src="' . $SITE_ROOT . '/assets/js/subnav.js"></script>',
        '</body>' );
    }
}

class PageGenerator extends DisplayableContentContainer implements iDisplayableContentContainer
{
    protected $head_elem_;
    protected $body_elem_;

    public function __construct( $title = "", $subtitle = "" )
    {
        \PRINT_DEBUG( "Constructing new PageGenerator: " . $title );
        parent::__construct( $title );

        $this->addChild( new HeadElem( $title, $subtitle ) );
        $this->head_elem_ = &$this->child_containers_[$this->size() - 1];

        $this->addChild( new BodyElem() );
        $this->body_elem_ = &$this->child_containers_[$this->size() - 1];
    }

    public function &getHead()
    {
        return $this->head_elem_;
    }

    public function &getBody()
    {
        return $this->body_elem_;
    }

    public function display( $parent_offset = '' )
    {
        global $TAB;

        $this->printWithOffset( $parent_offset,
        '<!DOCTYPE html>',
        '<html lang="en">' );

        $this->displayChildren(
        $TAB . $parent_offset );

        $this->printWithOffset( $parent_offset,
        '</html>' );
    }
}

?>
