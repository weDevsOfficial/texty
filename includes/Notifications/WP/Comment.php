<?php

namespace Texty\Notifications\WP;

use Texty\Notifications\Notification;

class Comment extends Notification {

    /**
     * @var int
     */
    private $comment_id;

    /**
     * Initialize
     */
    public function __construct() {
        $this->title              = __( 'New Comment', 'texty' );
        $this->id                 = 'comment';
        $this->default_recipients = [ 'administrator' ];
        $this->default            = <<<'EOD'
A new comment added on the post "{post_title}" by {author} ({email}).

View comment: {post_url}
EOD;
    }

    /**
     * Set the user ID
     *
     * @param int $comment_id
     *
     * @return self
     */
    public function set_comment( $comment_id ) {
        $this->comment_id = $comment_id;

        return $this;
    }

    /**
     * Return the message
     *
     * @return string
     */
    public function get_message() {
        $message = parent::get_message_raw();

        if ( ! $this->comment_id ) {
            return $message;
        }

        $comment = get_comment( $this->comment_id );

        foreach ( $this->replacement_keys() as $search => $value ) {
            $value   = ( $search === 'post_url' ) ? get_permalink( $comment->comment_post_ID ) : $comment->$value;
            $message = str_replace( '{' . $search . '}', $value, $message );
        }

        $message = $this->replace_global_keys( $message );

        return $message;
    }

    /**
     * Return recipients
     *
     * @return array
     */
    public function get_recipients() {
        return $this->get_numbers_by_roles();
    }

    /**
     * Get replacement keys
     *
     * @return array
     */
    public function replacement_keys() {
        return [
            'author'     => 'comment_author',
            'email'      => 'comment_author_email',
            'author_url' => 'comment_author_url',
            'comment'    => 'comment_content',
            'ip'         => 'comment_author_ip',
            'post_id'    => 'comment_post_ID',
            'post_title' => 'post_title',
            'post_url'   => '',
        ];
    }
}
