<?php

/***************************************************************************
 *  robotics.usc.edu/~ekaszubski/research/index.php
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

$ROOT = '../';
chdir( $ROOT );
include_once 'php/global_settings.php';
\PRINT_DEBUG( "included: " . __FILE__ );

include_once 'php/classes/page_generator.php';
include_once 'php/content/research_side_post.php';
include_once 'php/content/projects_side_post.php';

$page_gen = new PageGenerator( 'Research' );

$top_nav = &$page_gen->getBody()->getHeader();
$top_nav->getChild( 3 )->setSelected();

$main_content = &$page_gen->getBody()->getPage()->getMainContent();
$side_content = &$page_gen->getBody()->getPage()->getSideContent();

$main_content->addChild( new MainPost( 'Social Behavior Library' ) );
$main_content->getChild()->addChild
(
    new MainPostSection( 'The Social Behavior Library aims to make human-robot interaction more natural through principled methods.', '' ),
    new MainPostSection( new HtmlLink( 'More Info', 'link:/research/sbl' ) )
);

$main_content->addChild( new MainPost( 'Stroke Project' ) );
$main_content->getChild()->addChild
(
    new MainPostSection( 'This research seeks to establish a working model for near-autonomous assistance in rehabilitation of (often elderly) stroke patients using humanoid robots.', '' ),
    new MainPostSection( new HtmlLink( 'More Info', 'link:/research/stroke_rehab' ) )
);

$main_content->addChild( new MainPost( 'SeaBee III' ) );
$main_content->getChild()->addChild
(
    new MainPostSection( 'SeaBee III is an AUV designed to compete in the annual AUVSI RoboSub event.', '' ),
    new MainPostSection( new HtmlLink( 'More Info', 'target:_blank', 'link:http://code.google.com/p/seabee3-ros-pkg' ) )
);

$main_content->addChild( new MainPost( 'Autonomous Navigation for Pioneers' ) );
$main_content->getChild()->addChild
(
    new MainPostSection( 'This research sought to find methods of autonomous navigation for the Pioneer AT and Pioneer DX robots as a proof-of-concept.', '' ),
    new MainPostSection( new HtmlLink( 'More Info', 'link:/research/pioneer_nav' ) )
);

#$side_content->addChild( \content\side_post\projects( '047fc674f98e6a7540a12f4e770b95ec' ) );

/*$side_content->addChild( new SidePost( 'Other Projects' ) );
$side_content->getChild()->addChild(
    new SidePostSection( 'seabee3-ros-pkg', '(C++/ROS) A stack containing drivers and algorithms for the SeaBee AUV' ),
    new SidePostSeparator(),
    new SidePostSection( '<a href="' . $ROOT . 'projects/matlab">MATLAB/Mex Tools</a>', '(C++/ROS) A stack designed to compile Mex files (executable shared libraries capable of interfacing with MATLAB) using CMake and, optionally, ROS.' ) );*/

//$side_content->addChild( \content\side_post\research() );
$side_content->addChild( \content\side_post\projects() );

$page_gen->display();

?>
