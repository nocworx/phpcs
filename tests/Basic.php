<?php
/**
 * NOCWorx Datacenter Management Suite
 *
 * <pre>
 * +----------------------------------------------------------------------+
 * | NOCWorx                                                              |
 * +----------------------------------------------------------------------+
 * | Copyright (c) 2006-2015 NOCWorx L.L.C., All Rights Reserved.         |
 * +----------------------------------------------------------------------+
 * | Redistribution and use in source form, with or without modification  |
 * | is NOT permitted without consent from the copyright holder.          |
 * |                                                                      |
 * | THIS SOFTWARE IS PROVIDED BY THE AUTHOR AND CONTRIBUTORS "AS IS" AND |
 * | ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,    |
 * | THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A          |
 * | PARTICULAR PURPOSE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,    |
 * | EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,  |
 * | PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR   |
 * | PROFITS; OF BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY  |
 * | OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT         |
 * | (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE    |
 * | USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH     |
 * | DAMAGE.                                                              |
 * +----------------------------------------------------------------------+
 * </pre>
 */

 /**
  * Basic class
  *
  * @package Package
  * @subpackage Sub-package
  */
class Basic {

  /**
   * Constructor comment
   *
   * @param int $i
   * @param float $f
   */
  public function _constructor($i, $f) {
    print( "{$i} and {$f}" );
  }

  /**
   * If then else test!
   *
   * @param int $i
   * @param int $j
   * @param int $k
   */
  public function ifThenElse($i, $j, $k) {

    if($i > 0) {
      $i = 0;
    } elseif($j < 0) {
      $j = 0;
    } else {
      $k = 0;
    }
  }
}