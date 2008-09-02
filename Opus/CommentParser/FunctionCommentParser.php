<?php
/**
 * This file is part of OPUS. The software OPUS has been originally developed
 * at the University of Stuttgart with funding from the German Research Net,
 * the Federal Department of Higher Education and Research and the Ministry
 * of Science, Research and the Arts of the State of Baden-Wuerttemberg.
 *
 * OPUS 4 is a complete rewrite of the original OPUS software and was developed
 * by the Stuttgart University Library, the Library Service Center
 * Baden-Wuerttemberg, the Cooperative Library Network Berlin-Brandenburg,
 * the Saarland University and State Library, the Saxon State Library -
 * Dresden State and University Library, the Bielefeld University Library and
 * the University Library of Hamburg University of Technology with funding from
 * the German Research Foundation and the European Regional Development Fund.
 *
 * LICENCE
 * OPUS is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the Licence, or any later version.
 * OPUS is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details. You should have received a copy of the GNU General Public License
 * along with OPUS; if not, write to the Free Software Foundation, Inc., 51
 * Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 *
 * @category    CodingStandard
 * @author      Ralf Claussnitzer <ralf.claussnitzer@slub-dresden.de>
 * @copyright   Copyright (c) 2008, OPUS 4 development team
 * @license     http://www.gnu.org/licenses/gpl.html General Public License
 * @version     $Id$
 */

/**
 *
 * Extends parsing of function documentation.
 *
 * @category    CodingStandard
 * @package     Opus_CommentParser
 *
 */
class Opus_CommentParser_FunctionCommentParser extends PHP_CodeSniffer_CommentParser_FunctionCommentParser {
    
    /**
     * Hold dataProvider tag element.
     *
     * @var PHP_CodeSniffer_CommentParser_PairElement
     */
    protected $_dataProvider = null;
    
    /**
     * Extends set of allowed tags with the dataProvider tag.
     *
     * @return array(string => boolean)
     */
    protected function getAllowedTags()
    {
        $result = parent::getAllowedTags();
        // False means: the element is to occur only once. 
        $result['dataProvider'] = false;
        return $result;
    }
    
    /**
     * Parse the dataProvider tag from the comment tocken stream.
     *
     * @param array $tokens Array of comment tokens.
     * @return PHP_CodeSniffer_CommentParser_PairElement The parsed dataProvider tag element.
     */
    protected function parseDataProvider($tokens) {
        $dataProvider = new PHP_CodeSniffer_CommentParser_PairElement($this->previousElement, $tokens, 'dataProvider', $this->phpcsFile);
        $this->_dataProvider = $dataProvider;
        return $dataProvider;
    }
    
    /**
     * Return the dataProvider element previously parsed.
     *
     * @return PHP_CodeSniffer_CommentParser_PairElement The parsed dataProvider tag element.
     */
    public function getDataProvider() {
        return $this->_dataProvider;
    }
    
}