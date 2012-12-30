<?php

	namespace Gisleburt\Tools;

	use \Gisleburt\Templates\TemplateInterface;

	/**
	 * Simple Mailing tool
	 */
	class Mail {

		/**
		 * Recipients
		 * @var array
		 */
		protected $to;

		/**
		 *
		 * @var
		 */
		protected $from;

		protected $subject;

		protected $message;

		public function setTo($to) {
			$this->to = array($to);
		}

		public function addTo($to) {
			$this->to = (array)$this->to;
			$this->to[] = $to;
		}

		public function setFrom($from) {
			$this->from = $from;
		}

		public function setSubject($subject) {
			$this->subject = $subject;
		}

		public function setMessage($message) {
			$this->message = $message;
		}

		public function send() {
			if($this->to
					&& $this->from
					&& $this->subject
					&& $this->message) {

				$to = implode(', ', $this->to);
				$from = "From: $this->from";
				$subject = $this->subject;
				$message = wordwrap($this->message, 70, "\n\r");

				return mail($to, $subject, $message, $from);

			}
			else {
				return false;
			}
		}

	}
