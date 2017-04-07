<?php

/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 *
 * @package AAM
 * @author Vasyl Martyniuk <support@wpaam.com>
 * @copyright Copyright C 2013 Vasyl Martyniuk
 * @license GNU General Public License {@link http://www.gnu.org/licenses/}
 */
abstract class aam_Control_Subject {

    /**
     * Subject ID
     *
     * Whether it is User ID or Role ID
     *
     * @var string|int
     *
     * @access private
     */
    private $_id;

    /**
     * Subject itself
     *
     * It can be WP_User or WP_Role, based on what class has been used
     *
     * @var WP_Role|WP_User
     *
     * @access private
     */
    private $_subject;

    /**
     * List of Objects to be access controled for current subject
     *
     * All access control objects like Admin Menu, Metaboxes, Posts etc
     *
     * @var array
     *
     * @access private
     */
    private $_objects = array();

    /**
     * Constructor
     *
     * @param string|int $id
     *
     * @return void
     *
     * @access public
     */
    public function __construct($id) {
        //set subject
        $this->setId($id);
        //retrieve and set subject itself
        $this->setSubject($this->retrieveSubject());
    }

    /**
     * Trigger Subject native methods
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     *
     * @access public
     */
    public function __call($name, $arguments) {
        $subject = $this->getSubject();
        //make sure that method is callable
        if (method_exists($subject, $name)) {
            $response = call_user_func_array(array($subject, $name), $arguments);
        } else {
            aam_Core_Console::write(
                    "Method {$name} does not exist in " . get_class($subject)
            );
            $response = null;
        }

        return $response;
    }

    /**
     * Get Subject's native properties
     *
     * @param string $name
     *
     * @return mixed
     *
     * @access public
     */
    public function __get($name) {
        $subject = $this->getSubject();
        return $subject->$name;
    }

    /**
     * Set Subject's native properties
     *
     * @param string $name
     *
     * @return mixed
     *
     * @access public
     */
    public function __set($name, $value) {
        $subject = $this->getSubject();
        $subject->$name = $value;
    }

    /**
     * Set Subject ID
     *
     * @param string|int
     *
     * @return void
     *
     * @access public
     */
    public function setId($id) {
        $this->_id = $id;
    }

    /**
     * Get Subject ID
     *
     * @return string|int
     *
     * @access public
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * Get Subject
     *
     * @return WP_Role|WP_User
     *
     * @access public
     */
    public function getSubject() {
        return $this->_subject;
    }

    /**
     * Set Subject
     *
     * @param WP_Role|WP_User $subject
     *
     * @return void
     *
     * @access public
     */
    public function setSubject($subject) {
        $this->_subject = $subject;
    }

    /**
     * Get Access Objects
     *
     * @return array
     *
     * @access public
     */
    public function getObjects() {
        return $this->_objects;
    }

    /**
     * Get Individual Object
     *
     * @param string $object
     * @param mixed  $object_id
     *
     * @return aam_Control_Object
     *
     * @access public
     */
    public function getObject($object, $object_id = 0) {
        if (!isset($this->_objects[$object])) {
            $class_name = 'aam_Control_Object_' . ucfirst($object);
            if (class_exists($class_name)) {
                $this->_objects[$object] = new $class_name($this, $object_id);
            } else {
                $this->_objects[$object] = apply_filters(
                        'aam_object', null, $this, $object_id
                );
            }
        }

        //make sure that object exists, otherwise log it
        if (is_null($this->_objects[$object])) {
            aam_Core_Console::write("Object {$object} does not exist");
        }

        return $this->_objects[$object];
    }

    /**
     * Set Individual Access Object
     *
     * @param aam_Control_Object $object
     * @param string             $uid
     *
     * @return void
     *
     * @access public
     */
    public function setObject(aam_Control_Object $object, $uid) {
        $this->_objects[$uid] = $object;
    }

    /**
     * Get Subject Type
     *
     * @return string
     *
     * @access public
     */
    public function getType() {
        return get_class($this->getSubject());
    }

    /**
     *
     * @param type $capability
     * @return type
     */
    public function hasCapability($capability) {
        return $this->getSubject()->has_cap($capability);
    }

    /**
     * Retrieve list of subject's capabilities
     *
     * @return array
     *
     * @access public
     */
    abstract public function getCapabilities();

    /**
     * Save Access Parameters
     *
     * @param array $params
     *
     * @return boolean
     *
     * @access public
     */
    public function save(array $params) {
        //initialize the backup first
        $backup = array();

        foreach ($params as $object_id => $dump) {
            if ($object = $this->getObject($object_id)) {
                if (method_exists($object, 'backup')) {
                    $backup[$object_id] = $object->backup();
                }
                $object->save($dump);
            }
        }

        //store backup
        $this->getObject(aam_Control_Object_Backup::UID)->save($backup);
    }

    /**
     * Retrieve subject based on used class
     *
     * @return void
     *
     * @access protected
     */
    abstract protected function retrieveSubject();
}