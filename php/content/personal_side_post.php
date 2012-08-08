<?php

/***************************************************************************
 *  robotics.usc.edu/~ekaszubski/php/content/personal_side_post.php
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

include_once 'php/classes/side_post.php';

function personal()
{
    $post = new \SidePost( 'Personal' );
    $post->addChild(
    new \SidePostSection( 'Education', 'I\'m currently pursuing my BS in Computer Science/Computer Engineering at the University of Southern California.' ),
    new \SidePostSeparator(),
    new \SidePostSection( 'Positions', '<ul>',
                                      $TAB . '<li><p><a class="inline" target="_blank" href="http://robotics.usc.edu/interaction">Interaction Lab</a> - Research Assistant under <a class="inline" target="_blank" href="http://robotics.usc.edu/~maja">Prof. Maja Matari&#263</a></p></li>',
                                      $TAB . '<li><p><a class="inline" target="_blank" href="http://ilab.usc.edu">iLab</a> - Research Assistant under <a class="inline" target="_blank" href="http://ilab.usc.edu/itti/">Prof. Laurant Itti</a></p></li>',
                                      $TAB . '<li><p><a class="inline" target="_blank" href="http://uscrs.org">USCRS</a> - Software Lead, Underwater Robotics Team</p></li>',
                                      '</ul>' ),
    new \SidePostSeparator(),
    new \SidePostSection( 'Interests', '<ul>',
                                      $TAB . '<li><p>Generic software development; C/C++; meta-programming</p></li>',
                                      $TAB .'<li><p>Robot Control Systems and Planning Algorithms</p></li>',
                                      $TAB . '<li><p>Machine Learning</p></li>',
                                      $TAB . '<li><p>Data Transformation and Visualization</p></li>',
                                      '</ul>' ) );
    return $post;
}

?>
