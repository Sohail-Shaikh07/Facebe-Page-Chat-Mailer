<?php
function cr_facebook_get_messages()
{

    $fb = new Facebook\Facebook(['app_id' => FACEBOOK_APP_ID, 'app_secret' => FACEBOOK_APP_SECRET, 'default_graph_version' => GRAPH_VERSION]);

    global $wpdb;

    $no_new_messages = [];

    $all_pages = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}fb_pages_info WHERE active = 1");
    $emails = $wpdb->get_results("SELECT DISTINCT email FROM {$wpdb->prefix}fb_pages_info ");
    foreach ($all_pages as $page)
    {
        if (is_serialized($page->recent_message_at))
        {

            $rma = unserialize($page->recent_message_at);
        }
        else
        {
            $rma = [];
        }
        try
        {
            // Returns a `FacebookFacebookResponse` object
            $response = $fb->get('/' . $page->page_id . '/conversations?fields=link%2Cmessages%7Bmessage%2Ccreated_time%2Cfrom%7D%2Cunread_count%2Cupdated_time%2Cmessage_count', $page->token);
        }
        catch(FacebookExceptionsFacebookResponseException $e)
        {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        }
        catch(FacebookExceptionsFacebookSDKException $e)
        {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $graphNode = $response->getGraphEdge();
        //recent messages array
        $allMessages = [];
        //$graphNode = $graphNode;
        for ($i = 0;$i < count($graphNode);$i++)
        {
            if (!isset($rma[$graphNode[$i]['id']]))
            {
                $lastime = 0;
            }
            else
            {
                $lastime = $rma[$graphNode[$i]['id']];
            }
            if ($graphNode[$i]['unread_count'] > 0 && $lastime < strtotime($graphNode[$i]['updated_time']->format('Y-m-d H:i:s')))
            {
                $message = [];
                for ($j = 0;$j < $graphNode[$i]['unread_count'];$j++)
                {
                    if ($lastime < strtotime($graphNode[$i]['messages'][$j]['created_time']->format('Y-m-d H:i:s')))
                    {
                        array_push($message, ["message" => $graphNode[$i]['messages'][$j]['message'], "time" => $graphNode[$i]['messages'][$j]['created_time']]);
                    }

                }

                array_push($message, ["sender" => $graphNode[$i]["messages"][0]["from"]["name"]]);

                array_push($message, ['link' => $graphNode[$i]['link']]);
                $rma[$graphNode[$i]['id']] = strtotime($graphNode[$i]['updated_time']->format('Y-m-d H:i:s'));
                array_push($allMessages, $message);
            }
            

            $wpdb->update($wpdb->prefix . 'fb_pages_info', ['recent_message_at' => serialize($rma) ], ['page_id' => $page->page_id]);

        }

            $content = '';
            if (!empty($allMessages))
            {
                foreach ($allMessages as $messages)
                {

                    $content .= '<div>';
                    foreach ($messages as $message)
                    {
                        if (isset($message['message']) && isset($message['time']))
                        {
                            $content .= '<div style="padding-top:1%;" >' . $message['message'] . '</div>';
                            $content .= '<div>' . $message['time']->format('Y-m-d H:i:s') . '<div>';
                        }
                        if (isset($message['sender']))
                        {
                            $sender = isset($message['sender']) ? $message['sender'] : '';
                            $content .= '<div>' . $sender . '</div>';

                        }

                        if (isset($message['link']))
                        {
                            $link = isset($message['link']) ? $message['link'] : '';
                            $content .= "<a href='https://www.facebook.com{$message['link']}'>Reply through Facebook</a>";

                        }

                    }
                    $content .= '</div>';
                }
                $to = $page->email;
                $subject = 'New Messages for' . $page->name;
                $email = file_get_contents('mail.html', true);
                $email = str_replace('facebook-messages', $content, $email);
                $email = str_replace('page-name','New Messages for '. $page->name, $email);
                $body = $email;
                $headers = array(
                    'Content-Type: text/html; charset=UTF-8'
                );
                $mail = wp_mail($to, $subject, $body, $headers);
               var_dump($body);
            }
        if (empty($allMessages))
        {

            array_push($no_new_messages, array(
                'name' => $page->name,
                'email' => $page->email
            ));

        }

    }

        $no_content = '';
    foreach ($emails as $email)
    {
        for ($z = 0;$z < count($no_new_messages);$z++)
        {
            if ($no_new_messages[$z]['email'] == $email->email)
            {

                $no_content .= '<div style="padding-top:1%;" >No new message for ' . $no_new_messages[$z]['name'] . '</div>';
            }
        }}
if (!empty($no_new_messages)) {
  $subject = 'No new Messages';

        $email_template = file_get_contents('mail.html', true) ;

        $email_template = str_replace('page-name', 'No new Messages', $email_template);
         $email_template = str_replace('facebook-messages', $no_content, $email_template);
        $body = $email_template;
        $headers = array(
            'Content-Type: text/html; charset=UTF-8'
        );
        $mail = wp_mail( $email->email, $subject, $body, $headers );
}
      
}

?>
