<?php

/***************************************************************************
 *  robotics.usc.edu/~ekaszubski/projects/matlab/index.php
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

$page_gen = new PageGenerator( 'MATLAB/Mex Tools', 'A set of tools designed as an alternative to the MATLAB "mex" tool' );

$main_content = &$page_gen->getBody()->getPage()->getMainContent();
$side_content = &$page_gen->getBody()->getPage()->getSideContent();

$main_content->addChild( new MainPost( 'Summary' ) );
$main_content->getChild()->addChild
(
    new MainPostSection( 'Allows for "easy" compliation against the MATLAB/Mex libraries (from an existing MATLAB installation) using CMake', 'Also included is a C++ wrapper around the mxArray data type and a simple ROS/Mex bridge that allows for ROS messages to be sent and received within a Mex file.' )
);
$main_content->addChild( new MainPost( 'C/C++' ) );
$main_content->getChild()->addChild
(
    new MainPostSection( 'Provides a matlab::Mat C++ wrapper', 'This data structure is designed to cleanly wrap mxArray *, simplify data passing between MATLAB and C++, and allow for type-safe operations on data.' )
);
$main_content->addChild( new MainPost( 'CMake' ) );
$main_content->getChild()->addChild
(
    new MainPostSection( 'Hurray, macros!',
        '<ul>',
        $TAB . '<li><p>An include_mex() macro has been created to add the CMake definitions necessary for targets to be linked against MATLAB/Mex</p></li>',
        $TAB . '<li><p>An add_mex() macro has been created, similar to add_executable(), that will compile the given target and sources as a shared library linked against the appropriate MATLAB/Mex libraries. The target is then automatically given the appropriate mex[...] extension (dependent on operating system and architecture)</p></li>',
        '</ul>' )
);
$main_content->addChild( new MainPost( 'ROS' ) );
$main_content->getChild()->addChild
(
    new MainPostSection( 'Experimental ROS compatibility layer',
        '<ul>',
        $TAB . '<li><p>A matlab ROS package has been created to provide flags and macros to other ROS packages; simply use rosbuild_import( matlab, mex ) in your CMakeLists.txt to load the necessary macros.</p></li>',
        $TAB . '<li><p>An include_mex() macro is provided (identical to the above)</p></li>',
        $TAB . '<li><p>A rosbuild_add_mex() macro has been created (identical to add_mex() above except rosbuild_add_library() is used instead of add_library() )</p></li>',
        '</ul>' )
);

$side_content->addChild( new SidePost( 'Download' ) );
$side_content->getChild()->addChild(
    new SidePostSection( 'Requirements', '<ul>',
                                         $TAB . '<li><p>MATLAB</li>',
                                         $TAB . '<li><p>g++ >= 4.4</p></li>',
                                         '</ul>' ),
    new SidePostSeparator(),
    new SidePostSection( 'Source Code', 'These MATLAB tools are hosted on the <a href="http://sourceforge.net/projects/usc-ros-pkg/" target="_blank">usc-ros-pkg SVN</a> under <a href="http://sourceforge.net/apps/trac/usc-ros-pkg/browser/trunk/sandbox/matlab" target="_blank">trunk/sandbox/matlab</a>' ) );

$side_content->addChild( new SidePost( 'Documentation' ) );
$side_content->getChild()->addChild(
    new SidePostSection( 'v1.0 - Doxygen', '<ul>',
                                    $TAB .'<li><p><a class="inline" target="_blank" href="doc">Online</a></p></li>',
                                    $TAB .'<li><p><a class="inline" target="_blank" href="matlab_mex_cpp_toolkit.pdf">PDF</a></p></li>',
                                    '</ul>' ) );

$side_content->addChild( \content\side_post\projects( 'ababd94017179b7803737daa2caec6dd' ) );

/*$side_content->addChild( new SidePost( 'Other Projects' ) );
$side_content->getChild()->addChild(
    new SidePostSection( '<a href="' . $ROOT . 'projects/quickdev">quickdev</a>', '(C++/ROS) A toolbox designed to speed up the development time of code by providing generic implementations and utilities.' ),
    new SidePostSeparator(),
    new SidePostSection( 'seabee3-ros-pkg', '(C++/ROS) A stack containing drivers and algorithms for the SeaBee AUV' ) );*/

$side_content->addChild( \content\side_post\research() );

$page_gen->display();

?>
