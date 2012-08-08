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

$page_gen = new PageGenerator( 'humanoid', 'A framework designed to simplify the creation and analysis of humanoid data' );

$main_content = &$page_gen->getBody()->getPage()->getMainContent();
$side_content = &$page_gen->getBody()->getPage()->getSideContent();

/*$main_content->addChild( new MainPost( 'Info' ) );
$main_content->getChild()->addChild
(
    new MainPostSection( , '' )
);*/
$main_content->addChild( new MainPost( 'Related Software' ) );
$main_content->getChild()->addChild
(
    new MainPostSection( new HtmlLink( 'quickdev ROS stack', 'link:/projects/quickdev' ) )
);

$side_content->addChild( new SidePost( 'Download' ) );
$side_content->getChild()->addChild
(
    new SidePostSection( 'Requirements',
        '<ul>',
        $TAB . '<li>', new HtmlLink( 'ROS', 'target:_blank', 'link:http://ros.org' ), ' >= Diamondback</li>',
        $TAB . '<li>', new HtmlLink( 'quickdev ROS stack', 'target:_blank', 'link:/projects/quickdev' ), '</li>',
        $TAB . '<li>g++ >= 4.4</li>',
        '</ul>' ),
    new SidePostSection( 'Source Code', 'Humanoid is hosted on the ', new HtmlLink( 'usc-ros-pkg SVN', 'target:_blank', 'link:http://sourceforge.net/projects/usc-ros-pkg/' ), ' under ', new HtmlLink( 'trunk/humanoid', 'target:_blank', 'link:http://sourceforge.net/apps/trac/usc-ros-pkg/browser/trunk/humanoid' ) )
);

$side_content->addChild( new SidePost( 'Documentation' ) );
$side_content->getChild()->addChild(
    new SidePostSection( 'v1.0 - Doxygen', 'Coming soon' ) );

$side_content->addChild( \content\side_post\projects( 'b68ca7b7783b00ba22de2a2bf013ed97' ) );

/*$side_content->addChild( new SidePost( 'Other Projects' ) );
$side_content->getChild()->addChild(
    new SidePostSection( 'seabee3-ros-pkg', '(C++/ROS) A stack containing drivers and algorithms for the SeaBee AUV' ),
    new SidePostSeparator(),
    new SidePostSection( '<a href="' . $ROOT . 'projects/matlab">MATLAB/Mex Tools</a>', '(C++/ROS) A stack designed to compile Mex files (executable shared libraries capable of interfacing with MATLAB) using CMake and, optionally, ROS.' ) );*/

$side_content->addChild( \content\side_post\research() );

$page_gen->display();

?>
