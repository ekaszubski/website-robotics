<?php

/***************************************************************************
 *  robotics.usc.edu/~ekaszubski/php/content/research_side_post.php
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

function research()
{
    $filter = new \FilteredSidePost( 'Latest Research', 'Other Research', '/research' );
    $filter->addSection(
        new \SidePostSection(
            new \HtmlLink(
            'SBL',
            'id:SBL',
            'link:/research/sbl' ),
            'SBL aims to provide a standard platform on which the HRI community can build the next generation of research applications for humanoid interaction.' ),
        new \SidePostSection(
            new \HtmlLink(
            'SeaBee III',
            'id:seabee3',
            'link:/research/seabee3' ),
            'SeaBee III is an autonomous underwater research platform designed to compete in the annual AUVSI RoboSub event.' ),
        new \SidePostSection(
            new \HtmlLink(
            'Stroke Project',
            'id:stroke_rehab',
            'link:/research/stroke_rehab' ),
            'This research seeks to establish a working model for near-autonomous assistance in rehabilitation of (often elderly) stroke patients using humanoid robots.' ),
        new \SidePostSection(
            new \HtmlLink(
            'Autonomous Navigation for Pioneers',
            'id:pioneer_nav',
            'link:/research/pioneer_nav' ),
            'This research sought to find methods of autonomous navigation for the Pioneer AT and Pioneer DX robots as a proof-of-concept.' )
    );

    return $filter->apply( func_get_args() );
}

?>
