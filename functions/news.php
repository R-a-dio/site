<?php

    /**
     * Returns a formatted news post.
     *
     * @param $id int
     * @param $title string
     * @param $body string
     * @return string
     * 
     */

    function generate_news($id, $title, $body) {
        $html = <<<'HTML'

                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                        <h4 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-news-{{id}}">
                            {{title}}
                        </a>
                        </h4>
                        </div>
                        <div id="collapse-news-{{id}}" class="panel-collapse collapse in">
                        <div class="panel-body">
                            {{body}}
                        </div>
                        </div>
                    </div>

'HTML';
        $result = str_replace("{{id}}", $id, $html);
        $result = str_replace("{{title}}", $title, $result);
        $result = str_replace("{{body}}", $body, $result);

        return $result;
    }

