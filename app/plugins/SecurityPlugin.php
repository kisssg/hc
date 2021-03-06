<?php
use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Resource;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Acl\Adapter\Memory as AclList;

/**
 * SecurityPlugin
 *
 * This is the security plugin which controls that users only have access to the
 * modules they're assigned to
 */
class SecurityPlugin extends Plugin {
	
	/**
	 * Returns an existing or new access control list
	 *
	 * @returns AclList
	 */
	public function getAcl() {
		if (! isset ( $this->persistent->acl )) {			
			$acl = new AclList ();			
			$acl->setDefaultAction ( Acl::DENY );			
			// Register roles
			$roles = [ 
					'users' => new Role ( 'Users', 'Member privileges, granted after sign in.' ),
					'admins' => new Role ( 'Administrators', 'Admin privileges, granted after sign in.' ),
					'guests' => new Role ( 'Guests', 'Anyone browsing the site who is not signed in is considered to be a "Guest".' ) 
			];			
			foreach ( $roles as $role ) {
				$acl->addRole ( $role );
			}
			
			// Private area resources
			$privateResources = [ 
					'charts' => [ 
							'reset' 
					],
					'workstatus' => [ 
							'add',
							'index',
							'done',
							'delete',
							'deletebybatch',
							'get',
							'grant',
							'getstatus' 
					],
					'invoices' => [ 
							'index',
							'profile' 
					],
					'callback' => [ 
							'add',
							'update',
							'markDeletion',
							'restoreDeletion',
							'transfer',
							'saveRecAudit',
							'getRecAudit'
					],
					'journals'=>[
							'index',
							'search',
							'vrdScoreAdd',
							'vrdScoreDel',
							'vrdScores',
							'fetchStartPoints',
							'calcDistance',
							'clearStartPoints',
							'uploadDistance',
							'fetchLocations',
							'clearDistance',
							'distance',
							'createHomeLog',
							'delHomeLog'
					],
					'videoaudit'=>[
							'get',
							'add',
							'update',
							'delete',
							'show'
					],
					'camera'=>[
							'search',
							'scoreSave',
							'pick',
							'pickLLI',
							'batchManage',
							'scoreDel',
							'batchDelete',
							'batchEnable',
							'delUnenable',
							'checkCheating',
							'addIssue',
							'addCheatIssue',
							'addVisitResultIndex',
							'transfer',
							'getDateRange',
							'checkDuration'
					],
					'applications'=>[
							'apply',
							'approve',
							'reject',
					],
					'issues'=>[
							'addViolation',
							'delViolation',
							'getViolation',
							'getViolations',
							'getPunishment',
							'getPunishments',
							'addPunishment',
							'delPunishment',
							'add',
							'del',
							'update',
							'get',
							'getList',							
					]
			];
			foreach ( $privateResources as $resource => $actions ) {
				$acl->addResource ( new Resource ( $resource ), $actions );
			}
			
			// Public area resources
			$publicResources = [ 
					'signin' => [ 
							'index',
							'login' 
					],
					'signup' => [ 
							'index',
							'register' 
					],
					'errors' => [ 
							'show401',
							'show40101',
							'show404',
							'show500' 
					],
					'session' => [ 
							'index',
							'register',
							'start',
							'end' 
					],
					'index' => [ 
							'index' 
					],
					'charts' => [ 
							'index',
							'uncall',
							'totalcalled',
							'harassRecieved',
							'signin',
							'visitCheck',
							'dingCheck',
							'workStatus',
							'issues',
							'issueType',
							'harassmentType',
							'issueQCOverview',
							'checkEfficiency',
							'outsourcing',
							'checkEfficiencyAll',
							'cntRecording',
							'cntRecordingAll',
							'cntContracts',
							'cntContractsAll',
							'mysteryContracts',
							'mysteryAssess',
							'sumTimeCost',
							'cameraSum',
							'cameraDuration'
					],
					'mysterymonitor' => [ 
							'index' ,
							'getLCS',
							'saveRemark'
					],
					'workstatus' => [ 
							'items',
							'getpermission' ,
							'pickPermission'
					],
					'callback' => [ 
							'index',
							'delete',
							'recycleBin' 
					],
					'videoscore' => [
							'get',
							'add',
							'update',
							'delete',
							'show'
					],
					'collectors'=>[
							'search',
                                            'isearch'
					],
					'issues'=>[
							'index',
					]
			];
			foreach ( $publicResources as $resource => $actions ) {
				$acl->addResource ( new Resource ( $resource ), $actions );
			}
			
			// Grant access to public areas to both users and guests
			foreach ( $roles as $role ) {
				foreach ( $publicResources as $resource => $actions ) {
					foreach ( $actions as $action ) {
						$acl->allow ( $role->getName (), $resource, $action );
					}
				}
			}
			
			// Grant access to private area to role Users
			foreach ( $privateResources as $resource => $actions ) {
				foreach ( $actions as $action ) {
					$acl->allow ( 'Users', $resource, $action );
				}
			}
			
			// The acl is stored in session, APC would be useful here too
			$this->persistent->acl = $acl;
		}
		
		return $this->persistent->acl;
	}
	
	/**
	 * This action is executed before execute any action in the application
	 *
	 * @param Event $event        	
	 * @param Dispatcher $dispatcher        	
	 * @return boolean
	 */
	public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher) {
		$auth = $this->session->get ( 'auth' );
		if (! $auth) {
			$role = 'Guests';
		} else {
			$role = 'Users';
		}
		
		$controller = $dispatcher->getControllerName ();
		$action = $dispatcher->getActionName ();
		
		$acl = $this->getAcl ();
		
		if (! $acl->isResource ( $controller )) {
			$dispatcher->forward ( [ 
					'controller' => 'errors',
					'action' => 'show404' 
			] );
			
			return false;
		}
		
		$allowed = $acl->isAllowed ( $role, $controller, $action );
		if (! $allowed) {
			if ($controller === "workstatus") {
				$dispatcher->forward ( [ 
						'controller' => 'errors',
						'action' => 'show40101' 
				] );
				return false;
			}
			$dispatcher->forward ( [ 
					'controller' => 'errors',
					'action' => 'show401' 
			] );
			$this->session->destroy ();
			return false;
		}
	}
}
