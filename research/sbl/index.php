<?php

/***************************************************************************
 *  robotics.usc.edu/~ekaszubski/projects/quickdev/index.php
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

$ROOT = '../../';
chdir( $ROOT );
include_once 'php/global_settings.php';
\PRINT_DEBUG( "included: " . __FILE__ );

include_once 'php/classes/page_generator.php';
include_once 'php/content/research_side_post.php';
include_once 'php/content/projects_side_post.php';

$page_gen = new PageGenerator( 'SBL', 'The Social Behavior Library' );

//$page_gen->getBody()->getNav()->addChild( new NavItem( 'Research', $SITE_ROOT . '/research' ), new NavItem( 'Social Behavior Library' ) );

$main_content = &$page_gen->getBody()->getPage()->getMainContent();
$side_content = &$page_gen->getBody()->getPage()->getSideContent();

$main_content->addChild( new MainPost( 'About' ) );
$main_content->getChild()->addChild
(
    new MainPostSection( 'The Social Behavior Library aims to make human-robot interaction more natural through principled methods.', 'SBL aims to provide a standard platform on which the HRI community can build the next generation of research applications for humanoid interaction as well as generic computational models of social behavior. Key research areas include deixis, kinesics, oculesics, proxemics, and vocalics.' )
);
$main_content->addChild( new MainPost( 'Related Software' ) );
$main_content->getChild()->addChild
(
    new MainPostSection( '',
        '<ul>',
        $TAB .'<li>', new HtmlLink( 'sbl ROS stack', 'link:/projects/sbl' ), '</li>',
        $TAB .'<li>', new HtmlLink( 'humanoid ROS stack', 'link:/projects/humanoid' ), '</li>',
        $TAB .'<li>', new HtmlLink( 'quickdev ROS stack', 'link:/projects/quickdev' ), '</li>',
        '</ul>' )
);

$side_content->addChild( \content\side_post\research( 'cd5fdfe5b84f563c7846453454a1c223' ) );
$side_content->addChild( \content\side_post\projects() );

/*$side_content->addChild( new SidePost( 'Other Projects' ) );
$side_content->getChild()->addChild(
    new SidePostSection( 'seabee3-ros-pkg', '(C++/ROS) A stack containing drivers and algorithms for the SeaBee AUV' ),
    new SidePostSeparator(),
    new SidePostSection( '<a href="' . $ROOT . 'projects/matlab">MATLAB/Mex Tools</a>', '(C++/ROS) A stack designed to compile Mex files (executable shared libraries capable of interfacing with MATLAB) using CMake and, optionally, ROS.' ) );*/

$page_gen->display();

?>
