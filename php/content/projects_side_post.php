<?php

/***************************************************************************
 *  robotics.usc.edu/~ekaszubski/php/content/projects_side_post.php
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

namespace content\side_post;

include_once 'php/global_settings.php';
\PRINT_DEBUG( "included: " . __FILE__ );

include_once 'php/classes/filtered_side_post.php';

function projects()
{
    $filter = new \FilteredSidePost( 'Latest Projects', 'Other Projects', '/projects' );
    $filter->addSection(
        new \SidePostSection(
            new \HtmlLink(
                'quickdev ROS stack',
                'id:quickdev_stack',
                'link:/projects/quickdev' ),
            'A toolbox designed to speed up the development time of code by providing generic implementations and utilities.' ),
        new \SidePostSection(
            new \HtmlLink(
                'humanoid ROS stack',
                'id:humanoid_stack',
                'link:/projects/humanoid' ),
            'A framework designed to simplify the creation and analysis of humanoid data.' ),
        new \SidePostSection(
            new \HtmlLink(
                'sbl ROS stack',
                'id:sbl_stack',
                'link:/projects/sbl' ),
            'SBL aims to provide a standard platform on which the HRI community can build the next generation of research applications for humanoid interaction.' ),
        new \SidePostSection(
            new \HtmlLink(
                'seabee3-ros-pkg',
                'link:http://code.google.com/p/seabee3-ros-pkg',
                'target:_blank' ),
            'A stack containing drivers and algorithms for the SeaBee AUV' ),
        new \SidePostSection(
            new \HtmlLink(
                'MATLAB/Mex Tools',
                'id:matlab',
                'link:/projects/matlab' ),
            'A stack designed to compile Mex files (executable shared libraries capable of interfacing with MATLAB) using CMake and, optionally, ROS.' )
    );

    $args = func_get_args();

    return $filter->apply( $args );
}

?>
