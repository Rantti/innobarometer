<? php
/**
 * Lists all Post entities.
 *
 * This controller responds to two different routes with the same URL:
 *   * 'admin_post_index' is the route with a name that follows the same
 *     structure as the rest of the controllers of this class.
 *   * 'admin_index' is a nice shortcut to the backend homepage. This allows
 *     to create simpler links in the templates. Moreover, in the future we
 *     could move this annotation to any other controller while maintaining
 *     the route name and therefore, without breaking any existing link.
 *
 * @Route("/", name="admin_index")
 * @Route("/", name="admin_post_index")
 * @Method("GET")
 */
public function indexAction()
{
    $em = $this->getDoctrine()->getManager();
    $posts = $em->getRepository('AppBundle:Post')->findAll();

    return $this->render('admin/blog/index.html.twig', array('posts' => $posts));
}
?>
