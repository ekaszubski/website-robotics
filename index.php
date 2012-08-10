<?php

/***************************************************************************
 *  robotics.usc.edu/~ekaszubski/index.php
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
include_once 'php/classes/page_generator.php';
include_once 'php/content/personal_side_post.php';
include_once 'php/content/projects_side_post.php';
include_once 'php/content/research_side_post.php';

global $TAB;

$page_gen = new PageGenerator( 'Home' );

$top_nav = &$page_gen->getBody()->getHeader();
$top_nav->getChild( 2 )->setSelected();

$banner = &$page_gen->getBody()->getPage()->getBanner();
$banner = new PlainPostSection(
    '',
    '<header class="jumbotron">',
    '  <div class="hero-unit">',
    '    <div class="row">',
    '      <div class="span6 offset1">',
    '        <div class="row-fluid">',
    '          <div class="span12">',
    '            <h1 align="right">Edward T. Kaszubski</h1>',
    '          </div>',
    '        </div>',
    '        <div class="row-fluid">',
    '          <div class="span12">',
    '            <p align="right">',
    '              <a href="mailto:ekaszubski@gmail.com">ekaszubski@gmail.com</a>',
    '            </p>',
    '          </div>',
    '        </div>',
    '      </div>',
    '      <div class="span2">',
    '        <div class="row-fluid">',
    '          <div class="span12">',
    '            <a class="btn btn-primary pull-left" target="_blank" href="http://robotics.usc.edu">',
    '              USC Robotics',
    '            </a>',
    '          </div>',
    '        </div>',
    '        <p/>',
    '        <div class="row-fluid">',
    '          <div class="span12">',
    '            <a class="btn btn-primary pull-left" target="_blank" href="http://robotics.usc.edu/interaction">',
    '              Interaction Lab',
    '            </a>',
    '          </div>',
    '        </div>',
    '      </div>',
    '    </div>',
    '  </div>',
    '</header>' );

$main_content = $page_gen->getBody()->getPage()->getMainContent();
$side_content = $page_gen->getBody()->getPage()->getSideContent();

$main_content->addChild( new MainPost( 'About Me' ) );
$main_content->getChild()->addChild
(
    new PlainPostSection
    (
        '',
        '<ul class="thumbnails span3">',
        '  <li class="span2">',
        '    <div class="thumbnail">',
        '      <img src="' . $SITE_ROOT . '/images/20120316_145358-cropped-small.png" />',
        '    </div>',
        '  </li>',
        '</ul>'
    ),
    new MainPostSection
    (
        'Education',
        'I\'m currently pursuing my BS in Computer Science/Computer Engineering at the University of Southern California.'
    ),
    new MainPostSection
    (
        'Positions', '<ul>',
        $TAB . '<li>', new HtmlLink( 'Interaction Lab', 'target:_blank', 'link:http://robotics.usc.edu/interaction' ), ' - Research Assistant under ', new HtmlLink( 'Prof. Maja Matari&#263', 'target:_blank', 'link:http://robotics.usc.edu/~maja' ), '</li>',
        $TAB . '<li>', new HtmlLink( 'iLab', 'target:_blank', 'link:http://ilab.usc.edu' ), ' - Research Assistant under ', new HtmlLink( 'Prof. Laurant Itti', 'target:_blank', 'link:http://ilab.usc.edu/itti/' ), '</li>',
        $TAB . '<li>', new HtmlLink( 'USCRS', 'target:_blank', 'link:http://uscrs.org' ), ' - Software Lead, Underwater Robotics Team</li>',
        '</ul>'
    ),
    new MainPostSection
    (
        'Interests', '<ul>',
        $TAB . '<li>Generic software development; C/C++; meta-programming</li>',
        $TAB . '<li>Robot Control Systems and Planning Algorithms</li>',
        $TAB . '<li>Machine Learning</li>',
        $TAB . '<li>Data Transformation and Visualization</li>',
        '</ul>'
    )
);

#$side_content->addChild( content\side_post\personal() );

$side_content->addChild( content\side_post\research( 4 ) );
$side_content->addChild( content\side_post\projects( 4 ) );

$page_gen->display();

?>
