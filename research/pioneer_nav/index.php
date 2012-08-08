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

$page_gen = new PageGenerator( 'Autonomous Navigation for Pioneers', 'Utilizing the ROS nav stack and p2os' );

$main_content = &$page_gen->getBody()->getPage()->getMainContent();
$side_content = &$page_gen->getBody()->getPage()->getSideContent();

$main_content->addChild( new MainPost( 'About' ) );
$main_content->getChild()->addChild
(
    new MainPostSection( 'This research sought to find methods of autonomous navigation for the Pioneer AT and Pioneer DX robots as a proof-of-concept.', 'The target system was a dual-core mini-pc running Ubuntu 9.10. ROS was chosen as a development platform due primarily to its generic implementation of various robot navigation and localization algorithms. A Hokuyo URG-04LX-UG01 scanning laser rangefinder was used for sensing and mapping. Odometry estimates were read from the Pioneer’s onboard electronics. An indoor space was first mapped using the target platform and sensors via ROS. This map was then used to seed real-time SLAM and path-planning algorithms. The robot was successfully guided by the above software to navigate through narrow, cluttered spaces and dynamic environments with various obstacles.' )
);
$main_content->addChild( new MainPost( 'Related Software' ) );
$main_content->getChild()->addChild
(
    new MainPostSection( new HtmlLink( 'ROS nav stack', 'target:_blank', 'link:http://www.ros.org/wiki/navigation' ) )
);

$side_content->addChild( \content\side_post\research( '719f4f46d3ac5c59b14394c5796d00a2' ) );
$side_content->addChild( \content\side_post\projects() );

/*$side_content->addChild( new SidePost( 'Other Projects' ) );
$side_content->getChild()->addChild(
    new SidePostSection( 'seabee3-ros-pkg', '(C++/ROS) A stack containing drivers and algorithms for the SeaBee AUV' ),
    new SidePostSeparator(),
    new SidePostSection( '<a href="' . $ROOT . 'projects/matlab">MATLAB/Mex Tools</a>', '(C++/ROS) A stack designed to compile Mex files (executable shared libraries capable of interfacing with MATLAB) using CMake and, optionally, ROS.' ) );*/

$page_gen->display();

?>
